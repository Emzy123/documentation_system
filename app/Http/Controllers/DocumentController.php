<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function create()
    {
        $categories = \App\Models\DocumentCategory::all();
        return view('student.upload', compact('categories'));
    }

    public function store(\Illuminate\Http\Request $request, \App\Services\PreVerificationService $verifier)
    {
        $request->validate([
            'category_id' => 'required|exists:document_categories,id',
            'file' => 'required|file|mimes:pdf,jpg,png|max:10240', // 10MB max
        ]);

        $path = $request->file('file')->store('documents', 'public');
        
        // Fetch Category Name for Title
        $category = \App\Models\DocumentCategory::find($request->category_id);

        $document = auth()->user()->documents()->create([
            'category_id' => $request->category_id,
            'title' => $category->name,
            'file_path' => $path,
            'status' => 'pending', // Will be updated by verifier
        ]);
        
        // Auto-Verify
        $verifier->verify($document);

        return redirect()->route('student.dashboard')->with('status', 'Document uploaded and processed!');
    }

    public function index()
    {
         // Redirect to dashboard or show list
         return redirect()->route('student.dashboard');
    }
}
