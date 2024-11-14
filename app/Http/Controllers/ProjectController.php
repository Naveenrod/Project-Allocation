<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Application;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Returns the projects grouped by year and trimester in descending order
        $projects = Project::orderBy('year', 'desc')
            ->orderBy('trimester', 'desc')
            ->get()
            ->groupBy(function ($project) {
                return 'Trimester ' . $project->trimester . ' '. $project->year;
            });

        return view('project.list', compact('projects'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('project.create_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    // All the validation, table appending, and file storage takes place in this function
    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'title' => 'required|string|min:5',
            'description' => 'required|string|min:3',
            'team_size' => 'required|integer|between:3,6',
            'trimester' => 'required|integer|between:1,3',
            'year' => 'required|integer',
            'project_files.*' => 'mimes:jpeg,png,pdf|max:2048', // Adjust the allowed file types and size as needed
        ]);

        // Check if a project with the same name exists in the same trimester and year
        $existingProject = Project::where('title', $request->input('title'))
            ->where('trimester', $request->input('trimester'))
            ->where('year', $request->input('year'))
            ->exists();

        if ($existingProject) {
            // If it exists, redirect to the form with the appropriate error message
            return redirect()->back()->withInput()->withErrors(['title' => 'Project with an identical title already exists in the specified offering period.']);
        }

        // Create a new project and associate it with the currently authenticated industry partner
        $project = new Project([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'team_size' => $request->input('team_size'),
            'trimester' => $request->input('trimester'),
            'year' => $request->input('year'),
        ]);

        $user = Auth::user();
        $user->industryPartner->projects()->save($project);

        // Handle file uploads and store them in the project_files table
        if ($request->hasFile('project_files')) {
            foreach ($request->file('project_files') as $file) {
                // Determine the file type based on its extension
                $fileType = 'image';
                $extension = strtolower($file->getClientOriginalExtension());
                if ($extension === 'pdf')
                    $fileType = 'pdf';

                // Store the file in the project_files table
                $projectFile = new ProjectFile();
                $projectFile->project_id = $project->id;
                $projectFile->file_path = $file->store('project_files', 'public'); // Adjust storage path as needed
                $projectFile->file_type = $fileType;
                $projectFile->save();
            }
        }

        // Redirect to the project details page
        return redirect("projects/$project->id");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::find($id);
        return view('project.details', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::find($id);
        if (auth()->user()->usertype === 'industry_partner' && auth()->user()->industryPartner->id !== $project->industry_partner_id)
            return redirect()->back()->with('error', 'You do not have permission to modify this project.');
        return view('project.edit_form', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required|string|min:5',
            'description' => 'required|string|min:3',
            'team_size' => 'required|integer|between:3,6',
            'trimester' => 'required|integer|between:1,3',
            'year' => 'required|integer',
        ]);

        $project = Project::find($id);

        // Check if a project with the same name exists in the same trimester and year
        $existingProject = Project::where('title', $request->input('title'))
        ->where('trimester', $request->input('trimester'))
        ->where('year', $request->input('year'))
        ->first();

        if ($existingProject && $existingProject->id !== $project->id)
            // If it exists, redirect to the form with the appropriate error message
            return redirect()->back()->withInput()->withErrors(['title' => 'Project with an identical title already exists in the offering period.']);

        $project = Project::find($id);
        $project->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'team_size' => $request->input('team_size'),
            'trimester' => $request->input('trimester'),
            'year' => $request->input('year')
        ]);
        
        return redirect("projects/$project->id");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);

        if (auth()->user()->usertype === 'industry_partner' && auth()->user()->industryPartner->id !== $project->industry_partner_id)
            return redirect()->back()->with('error', 'No permission to modify this project.');

        if ($project->applicants()->count() > 0)
            return redirect()->back()->with('error', 'Applications allocated to the Project cannot be deleted.');

        $project->delete();
        return redirect("projects");
    }

    
    // This function handles everything that happens between the student clicking the apply button and the profile edit form
    public function apply(string $id)
    {
        $project = Project::find($id);
        $student = Auth::user()->student;

        // Check if GPA is empty or roles have not been set. If so, redirect student to complete their profile
        if (empty($student->gpa) || empty($student->roles)) {
            return redirect()->route('students.edit', $student->id)->with('error', 'Fill profile details.');
        }

        $appliedProjectsCount = $student->applications()->count();
        // If Student has applied to 3 projects already, redirect back with error message
        if ($appliedProjectsCount >= 3) 
            return redirect()->back()->with('error', 'Reached maximum limit of 3 project applications.');
        
        // If student has already applied to this project, redirect back with error message
        if ($student->applications()->where('project_id', $project->id)->exists())
            return redirect()->back()->with('error', 'Already applied for this project.');

        return view('project.application_form', compact('project'));
    }

    // This function handles the storage of student information received from the form.
    public function storeApplication(Request $request, string $id)
    {
        // Validate the request
        $request->validate([
            'justification' => 'required|string|min:3',
        ]);

        // Get the currently authenticated student
        $student = Auth::user()->student;

        // Create a new application record
        Application::create([
            'student_id' => $student->id,
            'project_id' => $id,
            'justification' => $request->input('justification'),
        ]);

        $project = Project::find($id);
        
        // Redirect to project details page
        return redirect()->route('projects.show', ['project' => $project->id]);

    }
}
