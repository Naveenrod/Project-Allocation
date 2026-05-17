<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\IndustryPartner;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Students — varied GPAs so auto-assign ordering is visible
        $students = [
            ['name' => 'Tom',   'email' => 'T@mail.com',     'gpa' => 5.5, 'roles' => ['Frontend Developer', 'Backend Developer']],
            ['name' => 'Alice', 'email' => 'alice@mail.com', 'gpa' => 6.5, 'roles' => ['Frontend Developer', 'UI/UX Designer']],
            ['name' => 'Bob',   'email' => 'bob@mail.com',   'gpa' => 4.0, 'roles' => ['Backend Developer', 'Database Administrator']],
            ['name' => 'Carol', 'email' => 'carol@mail.com', 'gpa' => 5.0, 'roles' => ['Frontend Developer', 'Backend Developer']],
            ['name' => 'David', 'email' => 'david@mail.com', 'gpa' => 3.5, 'roles' => ['Database Administrator']],
            ['name' => 'Emma',  'email' => 'emma@mail.com',  'gpa' => 6.0, 'roles' => ['Backend Developer', 'Data Scientist']],
        ];

        foreach ($students as $data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('12345678'),
                'usertype' => 'student',
            ]);
            Student::create([
                'user_id' => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'gpa'     => $data['gpa'],
                'roles'   => $data['roles'],
            ]);
        }

        // Industry Partners — first three approved so they can post projects
        $partners = [
            ['name' => 'Medi Care',          'email' => 'medicare@mail.com', 'approved' => true],
            ['name' => 'My Gov',             'email' => 'mygov@mail.com',    'approved' => true],
            ['name' => 'Tank Stream Design', 'email' => 'TSD@mail.com',      'approved' => true],
            ['name' => 'LSKD',               'email' => 'lskd@mail.com',     'approved' => false],
            ['name' => 'AirTasker',          'email' => 'air@mail.com',      'approved' => false],
            ['name' => 'Canva',              'email' => 'canva@mail.com',    'approved' => false],
        ];

        foreach ($partners as $data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('12345678'),
                'usertype' => 'industry_partner',
            ]);
            IndustryPartner::create([
                'user_id'  => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'approved' => $data['approved'],
            ]);
        }

        // Teacher
        $teacher = User::create([
            'name'     => 'Garry',
            'email'    => 'garry@gmail.com',
            'password' => Hash::make('12345678'),
            'usertype' => 'teacher',
        ]);
        Teacher::create([
            'user_id' => $teacher->id,
            'name'    => $teacher->name,
            'email'   => $teacher->email,
        ]);
    }
}
