<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::all();
        $query = Attendance::with(['student.user', 'course']);

        if ($request->has('course_id') && $request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('attendance_date') && $request->attendance_date) {
            $query->whereDate('attendance_date', $request->attendance_date);
        }

        $attendances = $query->latest('attendance_date')->paginate(20);

        return view('admin.attendance.index', compact('attendances', 'courses'));
    }

    public function create(Request $request)
    {
        $courses = Course::all();
        $selectedCourse = null;
        $students = [];
        $date = $request->get('date', now()->format('Y-m-d'));

        if ($request->has('course_id')) {
            $selectedCourse = Course::findOrFail($request->course_id);
            // Fetch students who have grades in this course (assuming enrollment is tracked via grades/enrollment, 
            // but for now we might just fetch all students or students in that program.
            // Since we don't have an 'enrollments' table yet, let's fetch ALL students for simplicity
            // or we could fetch students who have a grade record for this course (indicating enrollment).
            // Better approach for now: Fetch all students. In a real app, we'd filter by enrollment.
            $students = Student::with('user')->get();
        }

        return view('admin.attendance.create', compact('courses', 'selectedCourse', 'students', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:present,absent,late,excused',
        ]);

        foreach ($request->attendances as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'course_id' => $request->course_id,
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'status' => $data['status'],
                    'remarks' => $data['remarks'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance marked successfully.');
    }
}
