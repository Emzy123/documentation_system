<!DOCTYPE html>
<html>
<head>
    <style>
        body { 
            font-family: serif; 
            text-align: center; 
            border: 10px solid #003366;
            padding: 40px;
            height: 90%;
        }
        .title { font-size: 36px; font-weight: bold; margin-bottom: 20px; color: #003366; }
        .subtitle { font-size: 18px; margin-bottom: 40px; font-style: italic; }
        .name { font-size: 30px; font-weight: bold; border-bottom: 2px solid #000; display: inline-block; padding: 0 50px 10px; margin-bottom: 30px; }
        .content { font-size: 16px; line-height: 1.8; margin-bottom: 50px; }
        .signatures { width: 100%; margin-top: 50px; }
        .sig { width: 40%; display: inline-block; border-top: 1px solid #000; padding-top: 10px; margin: 0 4%; }
    </style>
</head>
<body>
    <div class="title">Certificate of Completion</div>
    <div class="subtitle">This is to certify that</div>
    
    <div class="name">{{ $user->name }}</div>
    
    <div class="content">
        has successfully completed the requirements for the program<br>
        <strong>{{ $student->program }}</strong><br>
        at the University of Excellence.<br>
        <br>
        Given this day, {{ $date }}.
    </div>

    <div class="signatures">
        <div class="sig">
            <strong>Dean of Students</strong>
        </div>
        <div class="sig">
            <strong>University Registrar</strong>
        </div>
    </div>
</body>
</html>
