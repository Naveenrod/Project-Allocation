<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Project;

class AutoAssignmentController extends Controller
{
    public function autoAssign(Request $request)
    {
        $year = $request->input('year');
        $trimester = $request->input('trimester');

        // Retrieve students who have applied for projects in the selected offering
        $students = Student::whereHas('applications', function ($query) use ($year, $trimester) {
            $query->where('year', $year)->where('trimester', $trimester);
        })->get();

        // Retrieve available projects in the selected offering
        $projects = Project::where('year', $year)->where('trimester', $trimester)->get();

        // Assignment algorithm (simplified version)
        foreach ($projects as $project) {
            // Assignment condition A: Match students to roles
            $projectRoles = $project->requiredRoles()->pluck('role_id');
            $studentsByRole = $students->groupBy('role');

            foreach ($projectRoles as $role) {
                if ($studentsByRole->has($role)) {
                    $student = $studentsByRole[$role]->pop();
                    $project->assignStudent($student);
                }
            }

            // Assignment condition B: Sort students by GPA
            $students = $students->sortByDesc('gpa');

            // Assignment condition C: Match students based on team size
            $teamSizeDiff = $project->teamSize - $project->assignedStudents->count();
            $studentsForProject = $students->splice(0, $teamSizeDiff);
            $project->assignStudents($studentsForProject);

            // Assignment condition D: Match nominated students
            $nominatedStudents = $students->filter(function ($student) use ($project) {
                return $student->nominatedProject() === $project;
            });

            $project->assignStudents($nominatedStudents);
        }

        // Save assignments to the database
        foreach ($projects as $project) {
            $project->save();
        }

        return redirect()->back()->with('success', 'Auto-assignment completed.');
    }
}
