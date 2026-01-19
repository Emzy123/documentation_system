<!DOCTYPE html>
<html>
<head>
    <title>Student ID Card</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; }
        .id-card {
            width: 350px;
            height: 220px;
            background: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            position: relative;
            overflow: hidden;
            float: left;
            margin-right: 20px;
        }
        .header { background: #0d6efd; color: white; padding: 10px; margin: -15px -15px 10px -15px; text-align: center; }
        .photo { width: 80px; height: 100px; background: #ddd; float: left; margin-right: 15px; border: 1px solid #999; }
        .details { float: left; font-size: 12px; }
        .details p { margin: 3px 0; }
        .label { font-weight: bold; color: #555; }
        .validity { position: absolute; bottom: 10px; right: 15px; font-size: 10px; color: #777; }
        .barcode { position: absolute; bottom: 10px; left: 15px; }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="header">
            <h3 style="margin:0;">StudentDocs University</h3>
        </div>
        
        <div class="photo">
            <!-- Placeholder for photo -->
            <div style="text-align: center; padding-top: 35px; color: #777;">PHOTO</div>
        </div>

        <div class="details">
            <p><span class="label">Name:</span> {{ Str::limit($student->user->name, 20) }}</p>
            <p><span class="label">ID No:</span> {{ $student->student_number }}</p>
            <p><span class="label">Program:</span> {{ Str::limit($student->program, 20) }}</p>
            <p><span class="label">Role:</span> Student</p>
        </div>

        <div class="barcode">
            <!-- Simulated barcode -->
            <div style="width: 100px; height: 30px; background: #000; color: #fff; font-size: 8px; text-align: center; line-height: 30px;">
                {{ $student->student_number }}
            </div>
        </div>
        
        <div class="validity">
            Valid until: Dec {{ date('Y') }}
        </div>
    </div>
</body>
</html>
