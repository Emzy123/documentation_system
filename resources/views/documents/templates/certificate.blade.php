<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Completion</title>
    <style>
        body { font-family: 'Times New Roman', serif; text-align: center; border: 10px solid #1a5f7a; padding: 50px; }
        .header { margin-bottom: 30px; }
        .title { font-size: 40px; font-weight: bold; color: #1a5f7a; margin-bottom: 10px; }
        .subtitle { font-size: 20px; color: #555; }
        .recipient { font-size: 30px; font-weight: bold; margin: 20px 0; border-bottom: 1px solid #ccc; display: inline-block; padding: 0 20px; }
        .program { font-size: 24px; font-weight: bold; margin: 10px 0; }
        .date { font-size: 18px; margin-top: 40px; }
        .signatures { margin-top: 80px; display: flex; justify-content: space-between; }
        .sig-block { width: 40%; border-top: 1px solid #000; padding-top: 10px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">StudentDocs University</h1>
        <p class="subtitle">Certificate of Completion</p>
    </div>

    <p>This is to certify that</p>

    <div class="recipient">
        {{ $student->user->name }}
    </div>

    <p>has successfully completed the requirements for the program</p>

    <div class="program">
        {{ $student->program }}
    </div>

    <p>with distinction.</p>

    <div class="date">
        Awarded this day, {{ date('F d, Y') }}
    </div>

    <table style="width: 100%; margin-top: 80px;">
        <tr>
            <td align="center">
                <div class="sig-block">Dean of Faculty</div>
            </td>
            <td align="center">
                <div class="sig-block">Vice Chancellor</div>
            </td>
        </tr>
    </table>
</body>
</html>
