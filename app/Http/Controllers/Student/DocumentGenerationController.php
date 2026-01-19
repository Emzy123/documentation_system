<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentGenerationController extends Controller
{
    protected $generator;

    public function __construct(\App\Services\DocumentGeneratorService $generator)
    {
        $this->generator = $generator;
    }

    public function admissionLetter()
    {
        $student = auth()->user()->student;
        if (!$student) abort(404, 'Student profile not found');
        return view('student.documents.admission-letter', compact('student'));
    }

    public function downloadAdmissionLetter()
    {
        $student = auth()->user()->student;
        if (!$student) abort(404, 'Student profile not found');
        return $this->generator->generateAdmissionLetter($student)->stream('admission_letter.pdf');
    }

    public function transcript()
    {
        $student = auth()->user()->student;
        if (!$student) abort(404, 'Student profile not found');
        return $this->generator->generateTranscript($student)->stream('transcript.pdf');
    }

    public function idCard()
    {
        $student = auth()->user()->student;
        if (!$student) abort(404, 'Student profile not found');
        return view('student.documents.id-card', compact('student'));
    }

    public function downloadIDCard()
    {
        $student = auth()->user()->student;
        if (!$student) abort(404, 'Student profile not found');
        return $this->generator->generateIDCard($student)->stream('id_card.pdf');
    }

    public function certificate()
    {
        $student = auth()->user()->student;
        if (!$student) abort(404, 'Student profile not found');
        return view('student.documents.certificate', compact('student'));
    }

    public function downloadCertificate()
    {
        $student = auth()->user()->student;
        if (!$student) abort(404, 'Student profile not found');
        return $this->generator->generateCertificate($student)->stream('certificate.pdf');
    }
}
