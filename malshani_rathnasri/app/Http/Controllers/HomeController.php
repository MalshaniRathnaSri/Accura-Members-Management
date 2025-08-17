<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembersModel; 
use App\Models\DS_DivisionModel;

class HomeController extends Controller
{
    public function index(Request $request)
    {
       $query = MembersModel::with('division');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('lastName', 'like', '%' . $request->search . '%');
        }

        $members = $query->get();

        return view('members.home', compact('members'));
    }
}
