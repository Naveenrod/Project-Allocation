<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Project;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    /**
     * Seed student applications for the 2026 T1 offering so auto-assign has data to work with.
     *
     * Expected auto-assign result (GPA desc: Alice 6.5 > Emma 6.0 > Tom 5.5 > Carol 5.0 > Bob 4.0 > David 3.5):
     *   Alice  → Healthcare Portal       (cap 3 → 1/3)
     *   Emma   → Government Services App (cap 4 → 1/4)
     *   Tom    → Healthcare Portal       (cap 3 → 2/3)
     *   Carol  → Healthcare Portal       (cap 3 → 3/3, full)
     *   Bob    → Government Services App (cap 4 → 2/4)
     *   David  → E-Commerce Platform     (cap 3 → 1/3)
     */
    public function run(): void
    {
        $tom   = Student::where('email', 'T@mail.com')->first();
        $alice = Student::where('email', 'alice@mail.com')->first();
        $bob   = Student::where('email', 'bob@mail.com')->first();
        $carol = Student::where('email', 'carol@mail.com')->first();
        $david = Student::where('email', 'david@mail.com')->first();
        $emma  = Student::where('email', 'emma@mail.com')->first();

        $healthcare  = Project::where('title', 'Healthcare Portal')->first();
        $govServices = Project::where('title', 'Government Services App')->first();
        $ecommerce   = Project::where('title', 'E-Commerce Platform')->first();

        // Tom (GPA 5.5): 1st choice Healthcare Portal, 2nd Government Services App
        Application::create(['student_id' => $tom->id,   'project_id' => $healthcare->id,  'justification' => 'Strong frontend skills and a passion for healthcare technology.']);
        Application::create(['student_id' => $tom->id,   'project_id' => $govServices->id, 'justification' => 'Experience building citizen-facing web applications.']);

        // Alice (GPA 6.5): 1st choice Healthcare Portal, 2nd E-Commerce Platform
        Application::create(['student_id' => $alice->id, 'project_id' => $healthcare->id,  'justification' => 'Top of my class in UI/UX, eager to improve the patient experience.']);
        Application::create(['student_id' => $alice->id, 'project_id' => $ecommerce->id,   'justification' => 'UI/UX design experience gained through previous e-commerce projects.']);

        // Bob (GPA 4.0): 1st choice Government Services App, 2nd E-Commerce Platform
        Application::create(['student_id' => $bob->id,   'project_id' => $govServices->id, 'justification' => 'Backend and database skills ideal for government data systems.']);
        Application::create(['student_id' => $bob->id,   'project_id' => $ecommerce->id,   'justification' => 'Experienced with payment gateway integrations and relational databases.']);

        // Carol (GPA 5.0): 1st choice Healthcare Portal, 2nd E-Commerce Platform
        Application::create(['student_id' => $carol->id, 'project_id' => $healthcare->id,  'justification' => 'Full-stack developer with a strong interest in digital health solutions.']);
        Application::create(['student_id' => $carol->id, 'project_id' => $ecommerce->id,   'justification' => 'Built a small-scale e-commerce site as part of my portfolio.']);

        // David (GPA 3.5): 1st choice E-Commerce Platform only
        Application::create(['student_id' => $david->id, 'project_id' => $ecommerce->id,   'justification' => 'Database administration experience suits a product-heavy platform.']);

        // Emma (GPA 6.0): 1st choice Government Services App, 2nd Healthcare Portal
        Application::create(['student_id' => $emma->id,  'project_id' => $govServices->id, 'justification' => 'Data science skills to improve government service recommendation systems.']);
        Application::create(['student_id' => $emma->id,  'project_id' => $healthcare->id,  'justification' => 'Interested in applying ML to predictive health analytics.']);
    }
}
