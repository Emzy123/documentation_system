<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = \App\Models\Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:courses,code',
            'name' => 'required|string',
            'credits' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        \App\Models\Course::create($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'code' => 'required|string|unique:courses,code,' . $id,
            'name' => 'required|string',
            'credits' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $course = \App\Models\Course::findOrFail($id);
        $course->update($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(string $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
