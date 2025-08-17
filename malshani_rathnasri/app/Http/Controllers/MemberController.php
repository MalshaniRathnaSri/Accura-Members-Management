<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembersModel; 
use App\Models\DS_DivisionModel;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $member = null;

        if ($request->has('member_id')) {
            $member = MembersModel::find($request->member_id);
        }

        $members = MembersModel::with('division')->get(); 
        $divisions = DS_DivisionModel::all(); 

        return view('members.member_form', compact('members', 'divisions', 'member'));
    }


    public function storeAndEdit(Request $request){
        $request-> validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'ds_division_id' => 'required|exists:ds_divisions,id',
            'dob' => 'required|date',
            'summary' => 'required|string',
        ]);

        $lastName = $request->lastName;

        if (strtoupper(trim($request->summary)) === "ACCURA") {
            $lastName .= " ACCURA";
        }

        if ($request->member_id) {
            $member = MembersModel::findOrFail($request->member_id);
            $member->update([
                'firstName' => $request->firstName,
                'lastName' => $lastName,
                'ds_division_id' => $request->ds_division_id,
                'dob' => $request->dob,
                'summary' => $request->summary,
            ]);

            $message = 'Member updated successfully.';
        } else {
            MembersModel::create([
                'firstName' => $request->firstName,
                'lastName' => $lastName,
                'ds_division_id' => $request->ds_division_id,
                'dob' => $request->dob,
                'summary' => $request->summary,
            ]);

            $message = 'Member added successfully.';
        }

        return redirect()->route('home')->with('success', $message);
    }
    public function delete($id)
    {
        $member = MembersModel::findOrFail($id);
        $member->delete(); 

        return redirect()->route('home')->with('success', 'Member deleted successfully.');
    }
}
