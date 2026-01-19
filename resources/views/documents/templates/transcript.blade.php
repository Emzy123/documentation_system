<!DOCTYPE html>
<html>
<head>
    <title>Academic Transcript</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .student-info { margin-bottom: 20px; width: 100%; }
        .student-info td { padding: 5px; font-weight: bold; }
        table.grades { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.grades th, table.grades td { border: 1px solid #000; padding: 8px; text-align: left; }
        table.grades th { background-color: #f2f2f2; }
        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h2>StudentDocs University</h2>
        <h4>OFFICIAL ACADEMIC TRANSCRIPT</h4>
    </div>

    <table class="student-info">
        <tr>
            <td>Name: {{ $student->user->name }}</td>
            <td>Student ID: {{ $student->student_number }}</td>
        </tr>
        <tr>
            <td>Program: {{ $student->program }}</td>
            <td>Date Issued: {{ date('F d, Y') }}</td>
        </tr>
    </table>

    <table class="grades">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Units</th>
                <th>Grade</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grades as $grade)
                <tr>
                    <td>{{ $grade->course->code ?? 'N/A' }}</td>
                    <td>{{ $grade->course->title ?? 'N/A' }}</td>
                    <td>{{ $grade->course->units ?? '-' }}</td>
                    <td>{{ $grade->grade }}</td>
                    <td>{{ $grade->points }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No academic records found for this student.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Cumulative GPA:</strong> {{ number_format($grades->avg('points') ?? 0, 2) }}</p>
    </div>

    <div class="footer">
        <p>This document is an official record of StudentDocs University.</p>
        <p>Generated on {{ date('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
