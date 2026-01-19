<?php

namespace App\Services;

use App\Models\Student;
use App\Models\GeneratedDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentGeneratorService
{
    public function generateAdmissionLetter(Student $student, $save = false)
    {
        $pdf = Pdf::loadView('documents.templates.admission_letter', compact('student'));
        
        if ($save) {
            $filename = 'admission_letter_' . $student->student_number . '_' . time() . '.pdf';
            $path = 'generated/' . $filename;
            Storage::disk('public')->put($path, $pdf->output());
            
            GeneratedDocument::create([
                'student_id' => $student->id,
                'type' => 'Admission Letter',
                'file_path' => $path,
            ]);
            
            return $path;
        }
        
        return $pdf;
    }

    public function generateCertificate(Student $student, $save = false)
    {
        $pdf = Pdf::loadView('documents.templates.certificate', compact('student'));
        $pdf->setPaper('a4', 'landscape');

        if ($save) {
            $filename = 'certificate_' . $student->student_number . '_' . time() . '.pdf';
            $path = 'generated/' . $filename;
            Storage::disk('public')->put($path, $pdf->output());

            GeneratedDocument::create([
                'student_id' => $student->id,
                'type' => 'Certificate',
                'file_path' => $path,
            ]);

            return $path;
        }

        return $pdf;
    }

    public function generateIDCard(Student $student, $save = false)
    {
        $pdf = Pdf::loadView('documents.templates.id_card', compact('student'));
        // ID Card custom size (approx credit card size in points 85.6mm x 53.98mm)
        // 1mm = 2.83465 pt
        // 85.6 * 2.83465 = 242.6
        // 53.98 * 2.83465 = 153.0
        $pdf->setPaper([0, 0, 243, 153], 'landscape'); 

        return $pdf;
    }

    public function generateTranscript(Student $student, $save = false)
    {
        // For now, loading dummy grades if none exist
        $grades = $student->grades()->with('course')->get();
        $pdf = Pdf::loadView('documents.templates.transcript', compact('student', 'grades'));
        
        return $pdf;
    }
}
