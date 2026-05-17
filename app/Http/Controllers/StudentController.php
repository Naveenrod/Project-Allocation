<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
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
        $students = Student::paginate(15);
        return view('student.list', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        return view('student.details', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::find($id);

        if (auth()->user()->usertype === 'student' && auth()->user()->student->id !== $student->id) {
            return redirect()->back()->with('error', "No permission to modify another student's information.");
        }

        $studentRoles = $student->roles ?? [];

        return view('student.edit_form', compact('student', 'studentRoles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $this->validate($request, [
            'gpa' => 'required|numeric|between:0,7',
            'roles' => 'required|array',
        ]);

        // Ownership check — only the owning student (or teacher) may update
        $student = Student::findOrFail($id);
        if (auth()->user()->usertype === 'student' && auth()->user()->student->id !== $student->id) {
            return redirect()->back()->with('error', 'No permission to modify another student\'s information.');
        }

        // Update the GPA
        $student->gpa = $request->input('gpa');

        // Roles cast as array by the model — no manual json_encode needed
        $student->roles = $request->input('roles');

        $student->save();

        // Redirect to the student's profile page.
        return redirect("students/$student->id");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}
