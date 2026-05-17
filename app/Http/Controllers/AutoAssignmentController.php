<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class AutoAssignmentController extends Controller
{
    public function autoAssign(Request $request)
    {
        $request->validate([
            'year'      => 'required|integer',
            'trimester' => 'required|integer|between:1,3',
        ]);

        $year      = $request->input('year');
        $trimester = $request->input('trimester');

        // Get all projects for this offering
        $projects = Project::where('year', $year)
            ->where('trimester', $trimester)
            ->get();

        if ($projects->isEmpty()) {
            return redirect()->back()->with('error', 'No projects found for the selected offering.');
        }

        // Reset any previous assignments for this offering
        DB::table('student_project')
            ->whereIn('project_id', $projects->pluck('id'))
            ->update(['assigned' => false]);

        // Get all students who applied to projects in this offering, sorted by GPA descending
        $students = Student::whereHas('applications', function ($query) use ($year, $trimester) {
            $query->where('year', $year)->where('trimester', $trimester);
        })->orderByDesc('gpa')->get();

        $assignedCount = 0;

        foreach ($students as $student) {
            // Get the projects this student applied to in this offering, preserving application order
            $appliedProjects = $student->applications()
                ->where('year', $year)
                ->where('trimester', $trimester)
                ->orderBy('student_project.created_at')
                ->get();

            foreach ($appliedProjects as $project) {
                $currentAssigned = $project->assignedStudents()->count();

                if ($currentAssigned < $project->team_size) {
                    // Assign this student to this project
                    DB::table('student_project')
                        ->where('student_id', $student->id)
                        ->where('project_id', $project->id)
                        ->update(['assigned' => true]);

                    $assignedCount++;
                    break; // Student is assigned — move to the next student
                }
            }
        }

        $totalStudents = $students->count();
        $unassigned    = $totalStudents - $assignedCount;

        $message = "Auto-assignment completed. {$assignedCount} of {$totalStudents} students assigned.";
        if ($unassigned > 0) {
            $message .= " {$unassigned} student(s) could not be assigned (all applied projects are at capacity).";
        }

        return redirect()->back()->with('success', $message);
    }
}
