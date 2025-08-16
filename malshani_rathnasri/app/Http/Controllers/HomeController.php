<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembersModel; 
use App\Models\DS_DivisionModel;

class HomeController extends Controller
{
    public function index()
    {
        $members = MembersModel::with('division')->get(); 
        return view('members.home', compact('members'));
    }
}
