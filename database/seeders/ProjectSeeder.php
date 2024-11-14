<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seed some projects
        Project::create([
            'title' => 'Web App For Health Care',
            'description' => 'Description of the Web App needed For medi Care',
            'team_size' => 5,
            'trimester' => 1,
            'year' => 2023,
            'industry_partner_id' => 1, // Replace with the actual industry partner ID
        ]);

        Project::create([
            'title' => 'Web App For Emergency Care',
            'description' => 'Description of the Web App needed For medi Care',
            'team_size' => 4,
            'trimester' => 2,
            'year' => 2023,
            'industry_partner_id' => 1, // Replace with the actual industry partner ID
        ]);

        Project::create([
            'title' => 'Software for Olympics 2030',
            'description' => 'Description of the Software needed for Olympics 2030',
            'team_size' => 4,
            'trimester' => 2,
            'year' => 2024,
            'industry_partner_id' => 2, // Replace with the actual industry partner ID
        ]);
    }
}
