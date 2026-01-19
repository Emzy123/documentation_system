<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $students = \App\Models\Student::with(['user', 'grades.course'])->get();
        $courses = \App\Models\Course::all();
        return view('admin.grades.index', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|string',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
        ]);

        \App\Models\Grade::create($request->all());

        return redirect()->back()->with('success', 'Grade assigned successfully.');
    }
}
