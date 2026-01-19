<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        // Fetch Users who have documents requiring attention
        $students = \App\Models\User::whereHas('documents', function($q) {
            $q->whereIn('status', ['pending', 'flagged', 'auto_verified']);
        })->with(['student', 'documents' => function($q) {
            $q->latest();
        }])->get();

        // Calculate stats for the dashboard top bar
        $stats = [
            'flagged' => \App\Models\Document::where('status', 'flagged')->count(),
            'auto_verified' => \App\Models\Document::where('status', 'auto_verified')->count(),
            'pending' => \App\Models\Document::where('status', 'pending')->count(),
        ];
        
        return view('staff.dashboard', compact('students', 'stats'));
    }

    public function showStudent($id)
    {
        $user = \App\Models\User::with(['student', 'documents' => function($q) {
            $q->latest();
        }])->findOrFail($id);

        return view('staff.student_documents', compact('user'));
    }

    public function show($id)
    {
        // Kept for backward compatibility if needed, but showStudent is preferred now.
        $document = \App\Models\Document::with('user.student', 'category')->findOrFail($id);
        return view('staff.verify', compact('document'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'remarks' => 'nullable|string',
        ]);

        $document = \App\Models\Document::findOrFail($id);
        $previousStatus = $document->status;

        $document->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        // Audit Trail
        \App\Models\DocumentAudit::create([
            'document_id' => $document->id,
            'changed_by_user_id' => auth()->id(),
            'previous_status' => $previousStatus,
            'new_status' => $request->status,
        ]);

        // Activity Log
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'verified_document',
            'details' => "Document ID {$document->id} status changed to {$request->status}",
            'ip_address' => $request->ip(),
        ]);

        if ($request->status == 'approved') {
            event(new \App\Events\DocumentApproved($document));
        }

        return redirect()->route('staff.dashboard')->with('success', 'Document verified successfully.');
    }
}
