<!DOCTYPE html>
<html>
<head>
    <title>Admission Letter</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 50px; }
        .content { line-height: 1.6; }
        .signature { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>UNIVERSITY OF EXCELLENCE</h1>
        <p>Official Admission Letter</p>
    </div>

    <div class="content">
        <p><strong>Date:</strong> {{ $date }}</p>
        <p><strong>To:</strong> {{ $user->name }}</p>
        <p><strong>Student ID:</strong> {{ $student->student_number }}</p>

        <p>Dear {{ $user->name }},</p>

        <p>We are pleased to inform you that you have been admitted to the <strong>{{ $student->program }}</strong> program at the University of Excellence.</p>

        <p>Your academic journey begins now. Please report to the administration office for further instructions.</p>
    </div>

    <div class="signature">
        <p>Sincerely,</p>
        <br>
        <p><strong>Registrar</strong></p>
        <p>University of Excellence</p>
    </div>
</body>
</html>
