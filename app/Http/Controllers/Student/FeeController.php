<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            \Log::error('FeeController 404: Student profile missing for user ' . auth()->id());
            abort(404, 'Student profile not found.');
        }

        // Direct Query Bypass for Debugging -> Reverting to standard relation now that data is fixed.
        $fees = $student->fees()->with('payments')->latest()->get();

        // \Log::info("Debugging Fees for Student {$student->id}: Found " . $fees->count() . " records.");

        return view('student.fees.index', compact('fees'));
    }

    public function pay(\Illuminate\Http\Request $request, \App\Models\Fee $fee)
    {
        // 1. Verify fee belongs to student
        if ($fee->student_id !== auth()->user()->student->id) {
            abort(403);
        }

        // 2. Validate it's not already paid
        if ($fee->status === 'paid') {
            return back()->with('error', 'This fee is already paid.');
        }

        // 3. Create Payment Record (Mocking a successful transaction)
        $payment = $fee->payments()->create([
            'amount' => $fee->balance, // Pay full outstanding balance
            'payment_date' => now(),
            'method' => 'Online Payment', // or 'Card', 'Transfer'
            'reference_number' => 'REF-' . strtoupper(uniqid()),
            'status' => 'approved', // Auto-approve for demo
        ]);

        // 4. Update Fee Status
        $fee->update(['status' => 'paid']);

        return back()->with('success', 'Payment successful! Transaction Reference: ' . $payment->reference_number);
    }
}
