<?php

namespace App\Http\Controllers;

use App\Models\IndustryPartner;
use Illuminate\Http\Request;

class IndustryPartnerController extends Controller
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
        $industryPartners = IndustryPartner::paginate(9);
        return view('index', compact('industryPartners'));
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
        $industryPartner = IndustryPartner::find($id);
        $projects = $industryPartner->projects;
        return view('inp_details', compact('industryPartner', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }


    // This function redirects to the page displaying all the unapproved InP's for the Teacher to then approve
    public function unapproved()
    {
        $unapprovedPartners = IndustryPartner::where('approved', false)->get();
        return view('unapproved', compact('unapprovedPartners'));
    }

    // This function handles the approval of an InP
    public function approve(string $id)
    {
        // Find the Industry Partner by their ID.
        $industryPartner = IndustryPartner::find($id);

        // Approve the Industry Partner.
        $industryPartner->update(['approved' => true]);

        // Redirect or return a success response.
        return redirect()->back();
    }

}
