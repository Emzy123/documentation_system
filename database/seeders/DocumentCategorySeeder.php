<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable Foreign Key Checks to allow truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        
        \App\Models\RequiredDocument::truncate();
        DocumentCategory::truncate();
        
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        
        $categories = [
            // Admission Documents
            [
                'name' => 'JAMB Admission Letter',
                'description' => 'Official admission letter from JAMB.',
                'group' => 'Admission Documents',
                'is_mandatory' => true,
            ],
            [
                'name' => 'University Admission Letter',
                'description' => 'Official admission letter from the University.',
                'group' => 'Admission Documents',
                'is_mandatory' => true,
            ],
            
            // Academic Documents
            [
                'name' => 'O-Level Result',
                'description' => 'WAEC/NECO/NABTEB Statement of Result or Certificate.',
                'group' => 'Academic Documents',
                'is_mandatory' => true,
            ],
            [
                'name' => 'Secondary School Testimonial',
                'description' => 'Testimonial from your secondary school.',
                'group' => 'Academic Documents',
                'is_mandatory' => false,
            ],

            // Personal Identification
            [
                'name' => 'Birth Certificate / Declaration of Age',
                'description' => 'Official birth certificate or court affidavit.',
                'group' => 'Personal Identification',
                'is_mandatory' => true,
            ],
            [
                'name' => 'Passport Photograph',
                'description' => 'Recent passport-sized photograph.',
                'group' => 'Personal Identification',
                'is_mandatory' => true,
            ],
            [
                'name' => 'Local Government ID',
                'description' => 'Identification from your Local Government Area.',
                'group' => 'Personal Identification',
                'is_mandatory' => false,
            ],
            [
                'name' => 'State of Origin Certificate',
                'description' => 'Certificate of State of Origin.',
                'group' => 'Personal Identification',
                'is_mandatory' => false,
            ],
            [
                'name' => 'NIN Slip',
                'description' => 'National Identity Number slip.',
                'group' => 'Personal Identification',
                'is_mandatory' => false,
            ],

            // Medical & Clearance
            [
                'name' => 'Medical Fitness Report',
                'description' => 'Report from a recognized government hospital.',
                'group' => 'Medical & Clearance',
                'is_mandatory' => false,
            ],
            [
                'name' => 'Undertaking Forms',
                'description' => 'Signed undertaking forms.',
                'group' => 'Medical & Clearance',
                'is_mandatory' => false,
            ],
            [
                'name' => 'Examiner-Safe Statement',
                'description' => 'Signed Examiner-Safe Statement.',
                'group' => 'Medical & Clearance',
                'is_mandatory' => false,
            ],
        ];

        foreach ($categories as $cat) {
            $category = DocumentCategory::updateOrCreate(
                ['name' => $cat['name']],
                [
                    'description' => $cat['description'],
                    'group' => $cat['group']
                ]
            );

            // Update or Create RequiredDocument logic
            // Assuming we have a RequiredDocument model based on previous context, 
            // if not we will skip this part or check if I need to create it.
            // Based on StudentController code in step 66: "requiredDocs = \App\Models\RequiredDocument::..."
            // So RequiredDocument model exists.
            
            \App\Models\RequiredDocument::updateOrCreate(
                ['document_category_id' => $category->id],
                ['is_mandatory' => $cat['is_mandatory']]
            );
        }
    }
}
