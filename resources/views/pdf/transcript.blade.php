<!DOCTYPE html>
<html>
<head>
    <title>Academic Transcript</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <h2>OFFICIAL TRANSCRIPT OF RECORDS</h2>
        <h3>University of Excellence</h3>
    </div>

    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Student ID:</strong> {{ $student->student_number }}</p>
    <p><strong>Program:</strong> {{ $student->program }}</p>
    <p><strong>Date Issued:</strong> {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Sem/Year</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
            <tr>
                <td>{{ $grade->course->code }}</td>
                <td>{{ $grade->course->name }}</td>
                <td>{{ $grade->course->credits }}</td>
                <td>{{ $grade->semester }} {{ $grade->academic_year }}</td>
                <td>{{ $grade->grade }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
