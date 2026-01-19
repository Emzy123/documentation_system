<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $recentDocuments = $user->documents()->with('category')->latest()->take(5)->get();
        
        // Compliance Logic
        $requiredDocs = \App\Models\RequiredDocument::with('category')->get();
        $uploadedCategoryIds = $user->documents()->pluck('category_id')->toArray();
        
        $docGroups = [
            'Admission Documents' => [],
            'Academic Documents' => [],
            'Personal Identification' => [],
            'Medical & Clearance' => []
        ];
        
        $totalMandatory = 0;
        $fulfilledMandatory = 0;
        
        foreach ($requiredDocs as $req) {
            $category = $req->category;
            $groupName = $category->group ?? 'Other';
            
            $isUploaded = in_array($req->document_category_id, $uploadedCategoryIds);
            
            if (!isset($docGroups[$groupName])) {
                $docGroups[$groupName] = [];
            }
            
            $docGroups[$groupName][] = [
                'category' => $category,
                'is_mandatory' => $req->is_mandatory,
                'uploaded' => $isUploaded
            ];
            
            if ($req->is_mandatory) {
                $totalMandatory++;
                if ($isUploaded) {
                    $fulfilledMandatory++;
                }
            }
        }

        $progress = $totalMandatory > 0 ? round(($fulfilledMandatory / $totalMandatory) * 100) : 100;
        $missingMandatoryCount = $totalMandatory - $fulfilledMandatory;

        return view('student.dashboard', compact('recentDocuments', 'progress', 'docGroups', 'missingMandatoryCount'));
    }
}
