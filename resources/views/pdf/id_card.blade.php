<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 0; }
        body { 
            font-family: sans-serif; 
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #f0f0f0;
        }
        .card {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #003366 0%, #004080 100%);
            color: white;
            padding: 10px;
            box-sizing: border-box;
            position: relative;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #ffcc00;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .header h3 { margin: 0; font-size: 14px; text-transform: uppercase; }
        .header h4 { margin: 0; font-size: 10px; font-weight: normal; }
        
        .photo-area {
            width: 60px;
            height: 60px;
            background-color: #fff;
            float: left;
            margin-right: 10px;
            border: 2px solid #fff;
        }
        .details {
            float: left;
            font-size: 10px;
            line-height: 1.4;
        }
        .details strong { color: #ffcc00; }
        
        .footer {
            position: absolute;
            bottom: 5px;
            left: 10px;
            right: 10px;
            text-align: center;
            font-size: 8px;
            border-top: 1px solid rgba(255,255,255,0.3);
            padding-top: 3px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h3>University of Excellence</h3>
            <h4>Student Identity Card</h4>
        </div>
        
        <div class="content">
            <div class="photo-area">
                <!-- Placeholder for photo -->
                <div style="text-align:center; padding-top:20px; color:#ccc;">Photo</div>
            </div>
            <div class="details">
                <div><strong>Name:</strong> {{ $user->name }}</div>
                <div><strong>ID No:</strong> {{ $student->student_number }}</div>
                <div><strong>Program:</strong> {{ $student->program }}</div>
                <div><strong>Year:</strong> {{ $student->year_level }}</div>
                <div><strong>Valid Thru:</strong> {{ date('Y') + 1 }}</div>
            </div>
        </div>

        <div class="footer">
            This card is property of the University. If found, please return to any campus office.
        </div>
    </div>
</body>
</html>
