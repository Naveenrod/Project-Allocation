<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\IndustryPartner;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $medicare = IndustryPartner::where('email', 'medicare@mail.com')->first();
        $mygov    = IndustryPartner::where('email', 'mygov@mail.com')->first();
        $tsd      = IndustryPartner::where('email', 'TSD@mail.com')->first();

        // Legacy projects (2023–2024)
        Project::create([
            'title'               => 'Web App For Health Care',
            'description'         => 'A web application for health care management and patient data.',
            'team_size'           => 5,
            'trimester'           => 1,
            'year'                => 2023,
            'industry_partner_id' => $medicare->id,
        ]);

        Project::create([
            'title'               => 'Web App For Emergency Care',
            'description'         => 'An emergency response web application for medical teams.',
            'team_size'           => 4,
            'trimester'           => 2,
            'year'                => 2023,
            'industry_partner_id' => $medicare->id,
        ]);

        Project::create([
            'title'               => 'Software for Olympics 2030',
            'description'         => 'Event management and scheduling software for the 2030 Olympics.',
            'team_size'           => 4,
            'trimester'           => 2,
            'year'                => 2024,
            'industry_partner_id' => $mygov->id,
        ]);

        // 2026 Trimester 1 — active offering used by auto-assign demo
        Project::create([
            'title'               => 'Healthcare Portal',
            'description'         => 'A unified portal for patient records, appointment scheduling, and telehealth services.',
            'team_size'           => 3,
            'trimester'           => 1,
            'year'                => 2026,
            'industry_partner_id' => $medicare->id,
        ]);

        Project::create([
            'title'               => 'Government Services App',
            'description'         => 'A mobile-first application for citizens to access government services and submit applications online.',
            'team_size'           => 4,
            'trimester'           => 1,
            'year'                => 2026,
            'industry_partner_id' => $mygov->id,
        ]);

        Project::create([
            'title'               => 'E-Commerce Platform',
            'description'         => 'A full-featured e-commerce platform with product management, payments, and analytics dashboard.',
            'team_size'           => 3,
            'trimester'           => 1,
            'year'                => 2026,
            'industry_partner_id' => $tsd->id,
        ]);
    }
}
