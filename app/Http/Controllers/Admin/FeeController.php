<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Fee::with('student.user')->latest();

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('student_number') && $request->student_number) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('student_number', 'like', "%{$request->student_number}%");
            });
        }

        $fees = $query->paginate(20);

        return view('admin.fees.index', compact('fees'));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        return view('admin.fees.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        Fee::create([
            'student_id' => $request->student_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => 'unpaid',
        ]);

        return redirect()->route('admin.fees.index')->with('success', 'Fee assigned successfully.');
    }

    public function show(Fee $fee)
    {
        $fee->load(['student.user', 'payments']);
        return view('admin.fees.show', compact('fee'));
    }

    public function storePayment(Request $request, Fee $fee)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $fee->balance,
            'payment_date' => 'required|date',
            'method' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // create payment
            $fee->payments()->create([
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'method' => $request->method,
                'reference_number' => $request->reference_number,
            ]);

            // update fee status
            $totalPaid = $fee->payments()->sum('amount'); // refresh sum including new one
            
            if ($totalPaid >= $fee->amount) {
                $fee->update(['status' => 'paid']);
            } elseif ($totalPaid > 0) {
                $fee->update(['status' => 'partial']);
            }

            DB::commit();
            return back()->with('success', 'Payment recorded successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error recording payment: ' . $e->getMessage());
        }
    }
}
