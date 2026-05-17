<?php

namespace Tests\Feature;

use App\Models\IndustryPartner;
use App\Models\Project;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectAllocationTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function makeTeacher(): User
    {
        $user = User::factory()->create(['usertype' => 'teacher']);
        Teacher::create(['user_id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
        return $user;
    }

    private function makeIndustryPartner(bool $approved = true): array
    {
        $user = User::factory()->create(['usertype' => 'industry_partner']);
        $partner = IndustryPartner::create([
            'user_id'  => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'approved' => $approved,
        ]);
        return [$user, $partner];
    }

    private function makeStudent(float $gpa = 5.5, array $roles = ['developer']): array
    {
        $user = User::factory()->create(['usertype' => 'student']);
        $student = Student::create([
            'user_id' => $user->id,
            'name'    => $user->name,
            'email'   => $user->email,
            'gpa'     => $gpa,
            'roles'   => $roles,
        ]);
        return [$user, $student];
    }

    private function makeProject(IndustryPartner $partner, int $trimester = 1, int $year = 2024, int $teamSize = 3): Project
    {
        return Project::create([
            'industry_partner_id' => $partner->id,
            'title'               => 'Test Project ' . uniqid(),
            'description'         => 'A project description',
            'team_size'           => $teamSize,
            'trimester'           => $trimester,
            'year'                => $year,
        ]);
    }

    // -------------------------------------------------------------------------
    // Project creation
    // -------------------------------------------------------------------------

    public function test_approved_industry_partner_can_create_a_project(): void
    {
        [$user] = $this->makeIndustryPartner(approved: true);

        $response = $this->actingAs($user)->post('/projects', [
            'title'       => 'Unique Project Title',
            'description' => 'Some description here',
            'team_size'   => 4,
            'trimester'   => 1,
            'year'        => 2024,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('projects', ['title' => 'Unique Project Title']);
    }

    public function test_student_cannot_create_a_project(): void
    {
        [$user] = $this->makeStudent();

        $response = $this->actingAs($user)->post('/projects', [
            'title'       => 'Sneaky Project',
            'description' => 'Should be blocked',
            'team_size'   => 3,
            'trimester'   => 1,
            'year'        => 2024,
        ]);

        // Should be redirected away — middleware blocks students from store
        $response->assertRedirect();
        $this->assertDatabaseMissing('projects', ['title' => 'Sneaky Project']);
    }

    // -------------------------------------------------------------------------
    // Student applications
    // -------------------------------------------------------------------------

    public function test_student_can_apply_to_a_project(): void
    {
        [$partnerUser, $partner] = $this->makeIndustryPartner();
        $project = $this->makeProject($partner);
        [$studentUser, $student] = $this->makeStudent();

        $response = $this->actingAs($studentUser)->post("/application/{$project->id}", [
            'justification' => 'I have relevant experience.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('student_project', [
            'student_id' => $student->id,
            'project_id' => $project->id,
        ]);
    }

    public function test_student_cannot_apply_to_more_than_three_projects(): void
    {
        [$partnerUser, $partner] = $this->makeIndustryPartner();
        [$studentUser, $student] = $this->makeStudent();

        // Apply to 3 projects
        for ($i = 0; $i < 3; $i++) {
            $project = $this->makeProject($partner);
            $student->applications()->attach($project->id, ['justification' => 'reason']);
        }

        // Try a 4th
        $fourthProject = $this->makeProject($partner);
        $response = $this->actingAs($studentUser)->get("/projects/{$fourthProject->id}/apply");

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_student_cannot_apply_to_the_same_project_twice(): void
    {
        [$partnerUser, $partner] = $this->makeIndustryPartner();
        $project = $this->makeProject($partner);
        [$studentUser, $student] = $this->makeStudent();

        $student->applications()->attach($project->id, ['justification' => 'reason']);

        $response = $this->actingAs($studentUser)->get("/projects/{$project->id}/apply");

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    // -------------------------------------------------------------------------
    // Auto-assignment
    // -------------------------------------------------------------------------

    public function test_auto_assignment_assigns_students_to_projects(): void
    {
        $teacher = $this->makeTeacher();
        [$partnerUser, $partner] = $this->makeIndustryPartner();
        $project = $this->makeProject($partner, trimester: 1, year: 2024, teamSize: 3);

        [, $student1] = $this->makeStudent(gpa: 6.5);
        [, $student2] = $this->makeStudent(gpa: 5.0);

        $student1->applications()->attach($project->id, ['justification' => 'reason']);
        $student2->applications()->attach($project->id, ['justification' => 'reason']);

        $response = $this->actingAs($teacher)->post('/auto-assign', [
            'year'      => 2024,
            'trimester' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('student_project', [
            'student_id' => $student1->id,
            'project_id' => $project->id,
            'assigned'   => true,
        ]);
        $this->assertDatabaseHas('student_project', [
            'student_id' => $student2->id,
            'project_id' => $project->id,
            'assigned'   => true,
        ]);
    }

    public function test_auto_assignment_respects_team_size_capacity(): void
    {
        $teacher = $this->makeTeacher();
        [, $partner] = $this->makeIndustryPartner();
        $project = $this->makeProject($partner, trimester: 2, year: 2024, teamSize: 1);

        [, $student1] = $this->makeStudent(gpa: 7.0);
        [, $student2] = $this->makeStudent(gpa: 4.0);

        $student1->applications()->attach($project->id, ['justification' => 'reason']);
        $student2->applications()->attach($project->id, ['justification' => 'reason']);

        $this->actingAs($teacher)->post('/auto-assign', [
            'year'      => 2024,
            'trimester' => 2,
        ]);

        // Only the higher-GPA student should be assigned (team size = 1)
        $this->assertDatabaseHas('student_project', [
            'student_id' => $student1->id,
            'project_id' => $project->id,
            'assigned'   => true,
        ]);
        $this->assertDatabaseHas('student_project', [
            'student_id' => $student2->id,
            'project_id' => $project->id,
            'assigned'   => false,
        ]);
    }

    public function test_auto_assignment_does_not_assign_student_to_more_than_one_project(): void
    {
        $teacher = $this->makeTeacher();
        [, $partner] = $this->makeIndustryPartner();
        $project1 = $this->makeProject($partner, trimester: 3, year: 2024, teamSize: 3);
        $project2 = $this->makeProject($partner, trimester: 3, year: 2024, teamSize: 3);

        [, $student] = $this->makeStudent(gpa: 6.0);
        $student->applications()->attach($project1->id, ['justification' => 'reason']);
        $student->applications()->attach($project2->id, ['justification' => 'reason']);

        $this->actingAs($teacher)->post('/auto-assign', [
            'year'      => 2024,
            'trimester' => 3,
        ]);

        $assignedCount = \DB::table('student_project')
            ->where('student_id', $student->id)
            ->where('assigned', true)
            ->count();

        $this->assertEquals(1, $assignedCount);
    }

    // -------------------------------------------------------------------------
    // Industry partner approval
    // -------------------------------------------------------------------------

    public function test_teacher_can_approve_an_industry_partner(): void
    {
        $teacher = $this->makeTeacher();
        [, $partner] = $this->makeIndustryPartner(approved: false);

        $this->assertFalse((bool) $partner->approved);

        $response = $this->actingAs($teacher)->put("/industry-partners/approve/{$partner->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('industry_partners', [
            'id'       => $partner->id,
            'approved' => true,
        ]);
    }

    // -------------------------------------------------------------------------
    // Authorization — students index
    // -------------------------------------------------------------------------

    public function test_student_cannot_access_students_index(): void
    {
        [$user] = $this->makeStudent();

        $response = $this->actingAs($user)->get('/students');

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_teacher_can_access_students_index(): void
    {
        $teacher = $this->makeTeacher();
        [, $student] = $this->makeStudent();

        $response = $this->actingAs($teacher)->get('/students');

        $response->assertOk();
    }
}
