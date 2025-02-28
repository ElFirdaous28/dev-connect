<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Auth::user()->skills ?? [];
        $availableSkills = Skill::all() ?? [];
        return view('skills.index', compact('skills', 'availableSkills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exists = UserSkill::where('user_id', auth()->user()->id)
                           ->where('skill_id', $request->skill_id)
                           ->exists();
    
        if ($exists) {
            return redirect()->back()->with('success', 'This skill is already added!');
        }
    
        UserSkill::create([
            'user_id' => auth()->user()->id,
            'skill_id' => $request->skill_id,
        ]);
    
        return redirect()->back()->with('success', 'Skill added successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $userProgrammingLanguage = UserSkill::where('skill_id', $id)
                                                            ->where('user_id', auth()->user()->id)
                                                            ->first();
        if ($userProgrammingLanguage) {
            $userProgrammingLanguage->delete();
        }
        return redirect()->route('skills.index')->with('success', 'Skill  deleted successfully.');
    }
}
