<?php

namespace App\Listeners;

use App\Events\DocumentApproved;
use App\Models\RequiredDocument;
use App\Models\Document;
use App\Models\GeneratedDocument;
use App\Services\DocumentGeneratorService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckForDocumentGeneration implements ShouldQueue
{
    use InteractsWithQueue;

    protected $generator;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DocumentGeneratorService $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\DocumentApproved  $event
     * @return void
     */
    public function handle(DocumentApproved $event)
    {
        $document = $event->document;
        $user = $document->user;
        $student = $user->student;

        if (!$student) return;

        // Check Compliance
        $requiredDocs = RequiredDocument::where('is_mandatory', true)->pluck('document_category_id')->toArray();
        $uploadedCategoryIds = $user->documents()
                                    ->where('status', 'approved')
                                    ->pluck('category_id')
                                    ->toArray();

        // Check if all required categories are present in approved uploads
        $missing = array_diff($requiredDocs, $uploadedCategoryIds);

        if (empty($missing)) {
             // 1. Generate Admission Letter if not exists
             if (!GeneratedDocument::where('student_id', $student->id)->where('type', 'Admission Letter')->exists()) {
                 $this->generator->generateAdmissionLetter($student, true);
             }

             // 2. Generate Certificate if not exists (Optional, maybe trigger later?)
             // For now, let's auto-generate Admission Letter as per request.
        }
    }
}
