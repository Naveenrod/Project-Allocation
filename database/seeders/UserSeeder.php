<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\IndustryPartner;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed a student
        $student = User::create([
            'name' => 'Tom',
            'email' => 'T@mail.com',
            'password' => Hash::make('12345678'),
            'usertype' => 'student',
        ]);

        // populate the students table

        Student::create([
            'user_id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'gpa' => 0.0,
        ]);

        // Seed InP
        $partner = User::create([
            'name' => 'Medi Care',
            'email' => 'medicare@mail.com',
            'password' => Hash::make('12345678'),
            'usertype' => 'industry_partner',
        ]);

        // Automatically populate the industry_partners table
        IndustryPartner::create([
            'user_id' => $partner->id,
            'name' => $partner->name,
            'email' => $partner->email,
        ]);

        $partner = User::create([
            'name' => 'My Gov',
            'email' => 'mygov@mail.com',
            'password' => Hash::make('12345678'),
            'usertype' => 'industry_partner',
        ]);

        IndustryPartner::create([
            'user_id' => $partner->id,
            'name' => $partner->name,
            'email' => $partner->email,
        ]);

        $partner = User::create([
            'name' => 'Tank Stream Design',
            'email' => 'TSD@mail.com',
            'password' => Hash::make('12345678'),
            'usertype' => 'industry_partner',
        ]);

        IndustryPartner::create([
            'user_id' => $partner->id,
            'name' => $partner->name,
            'email' => $partner->email,
        ]);

        $partner = User::create([
            'name' => 'LSKD',
            'email' => 'lskd@mail.com',
            'password' => Hash::make('12345678'),
            'usertype' => 'industry_partner',
        ]);

        IndustryPartner::create([
            'user_id' => $partner->id,
            'name' => $partner->name,
            'email' => $partner->email,
        ]);

        $partner = User::create([
            'name' => 'AirTasker',
            'email' => 'air@mail.com',
            'password' => Hash::make('12345678'),
            'usertype' => 'industry_partner', 
        ]);

        IndustryPartner::create([
            'user_id' => $partner->id,
            'name' => $partner->name,
            'email' => $partner->email,
        ]);

        $partner = User::create([
            'name' => 'Canva',
            'email' => 'canva@mail.com',
            'password' => Hash::make('12345678'),
            'usertype' => 'industry_partner',
        ]);

        IndustryPartner::create([
            'user_id' => $partner->id,
            'name' => $partner->name,
            'email' => $partner->email,
        ]);

        $teacher = User::create([
            'name' => 'Garry',
            'email' => 'garry@gmail.com',
            'password' => Hash::make('12345678'),
            'usertype' => 'teacher',
        ]);

        Teacher::create([
            'user_id' => $teacher->id,
            'name' => $teacher->name,
            'email' => $teacher->email,
        ]);
    }
}
