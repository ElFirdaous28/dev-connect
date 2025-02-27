<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Display a listing of the certificates.
     */
    public function index()
    {
        $certificates = Auth::user()->certificates ?? [];
        return view('certificates.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new certificate.
     */
    public function create()
    {
        return view('certificates.create');
    }

    /**
     * Store a newly created certificate in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
        Certificate::create([
            'title' => $validated['title'],
            'provider' => $validated['provider'],
            'date' => $validated['date'],
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully.');
    }

    /**
     * Show the form for editing the specified certificate.
     */
    public function edit(Certificate $certificate)
    {
        return view('certificates.edit', compact('certificate'));
    }

    /**
     * Update the specified certificate in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $certificate->update([
            'title' => $validated['title'],
            'provider' => $validated['provider'],
            'date' => $validated['date'],
        ]);

        return redirect()->route('certificates.index')->with('success', 'Certificate updated successfully.');
    }

    /**
     * Remove the specified certificate from storage.
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
