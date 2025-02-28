<?php

namespace App\Http\Controllers;

use App\Models\ProgrammingLanguage;
use App\Models\UserProgrammingLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProgrammingLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programmingLanguages = Auth::user()->programmingLanguages ?? [];
        $availableLanguages = ProgrammingLanguage::all() ?? [];
        return view('programmingLanguages.index', compact('programmingLanguages', 'availableLanguages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'language_id' => 'required|exists:programming_languages,id',
        ]);

        $exists = UserProgrammingLanguage::where('user_id', auth()->id())
                                            ->where('programming_language_id', $request->input('language_id'))
                                            ->exists();

        if ($exists) {
            return redirect()->back()->with('success', 'This programming language is already added!');
        }

        UserProgrammingLanguage::create([
            'user_id' => auth()->id(),
            'programming_language_id' => $request->input('language_id'),
        ]);

        return redirect()->back()->with('success', 'Programming language added successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userProgrammingLanguage = UserProgrammingLanguage::where('programming_language_id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();
        if ($userProgrammingLanguage) {
            $userProgrammingLanguage->delete();
        }
        return redirect()->route('programming-languages.index')->with('success', 'Programming Language deleted successfully.');
    }
}
