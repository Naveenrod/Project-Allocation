<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\IndustryPartner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $industryPartners = IndustryPartner::all();
        return view('home', compact('industryPartners'));
    }

    // public function showProject($id)
    // {
    //     $project = Project::find($id);
    //     return view('project_details', compact('project'));
    // }
}
