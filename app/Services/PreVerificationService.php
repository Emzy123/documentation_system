<?php

namespace App\Services;

use App\Models\Document;
use App\Models\VerificationLog;
use Illuminate\Support\Str;

class PreVerificationService
{
    /**
     * Run all automated checks on the document.
     */
    public function verify(Document $document): string
    {
        $issues = [];
        $criticalFailures = [];
        $student = $document->user; 
        
        // Resolve absolute path for file operations
        $absolutePath = \Illuminate\Support\Facades\Storage::disk('public')->path($document->file_path);

        if (!file_exists($absolutePath)) {
            // Critical: File missing
            $document->update(['status' => 'rejected', 'remarks' => 'Critical: File not found on server.']);
            return 'rejected';
        }

        // --- RULE 1: STRICT FILE SIZE (100KB - 5MB) ---
        $fileSizeBytes = filesize($absolutePath);
        $minSize = 100 * 1024; // 100KB
        $maxSize = 5 * 1024 * 1024; // 5MB

        if ($fileSizeBytes < $minSize) {
            $criticalFailures[] = "File too small (<100KB). Potential empty or corrupt file.";
        } elseif ($fileSizeBytes > $maxSize) {
            $criticalFailures[] = "File too large (>5MB).";
        }

        // --- RULE 2: TYPE & RESOLUTION (Images Only) ---
        $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
        
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $imageSize = getimagesize($absolutePath);
            if ($imageSize) {
                $width = $imageSize[0];
                $height = $imageSize[1];
                
                // Rule 12: Resolution Check
                if ($width < 600 || $height < 600) {
                    $issues[] = "Low resolution image detected ({$width}x{$height}px). Minimum 600x600px required.";
                }
            } else {
                $criticalFailures[] = "Corrupt image file (cannot read dimensions).";
            }
        } elseif ($extension !== 'pdf') {
            $criticalFailures[] = "Invalid file format ($extension).";
        }

        // --- RULE 6: IDENTITY CONSISTENCY (Filename Heuristic) ---
        // Check if at least one part of the student's name appears in the filename
        $filename = basename($document->file_path);
        $nameParts = explode(' ', strtolower($student->name));
        $matchFound = false;
        
        // Remove common words/initials (< 3 chars) to avoid false positives on "A", "The"
        $significantParts = array_filter($nameParts, fn($p) => strlen($p) >= 3);
        
        if (empty($significantParts)) {
            // If name is just initials, skip strict check or rely on original logic
            $significantParts = $nameParts; 
        }

        foreach ($significantParts as $part) {
            if (str_contains(strtolower($filename), $part)) {
                $matchFound = true;
                break;
            }
        }

        if (!$matchFound) {
            $issues[] = "Filename verification failed: Document name does not match student profile.";
        }


        // --- DECISION LOGIC ---
        
        if (!empty($criticalFailures)) {
            $status = 'rejected';
            $remarks = "Auto-Rejected: " . implode(' ', $criticalFailures);
        } elseif (!empty($issues)) {
            $status = 'flagged';
            $remarks = "Flagged for Review: " . implode(' ', $issues);
        } else {
            $status = 'auto_verified';
            $remarks = "Passed all automated checks (Size, Resolution, Identity Integrity).";
        }

        // Update Document
        $previousStatus = $document->status;
        $document->update([
            'status' => $status,
            'remarks' => $remarks
        ]);

        // Log Verification Event
        VerificationLog::create([
            'document_id' => $document->id,
            'user_id' => 1, // Log as System/Admin
            'previous_status' => $previousStatus,
            'new_status' => $status,
            'remarks' => "[Engine] " . $remarks
        ]);

        return $status;
    }
}
