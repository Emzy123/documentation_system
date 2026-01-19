<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TranscriptController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            return redirect()->route('student.dashboard')->with('error', 'Student profile not found.');
        }

        $grades = $student->grades()->with('course')->get();
        return view('student.transcript', compact('grades'));
    }
}
