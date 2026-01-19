<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update documents table
        if (Schema::hasTable('documents') && !Schema::hasColumn('documents', 'remarks')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->text('remarks')->nullable()->after('status');
            });
        }

        // 2. Create required_documents table
        if (!Schema::hasTable('required_documents')) {
            Schema::create('required_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('document_category_id')->constrained()->onDelete('cascade');
                $table->string('program_id')->nullable(); // Can be specific program code or null for global
                $table->string('semester')->nullable();
                $table->boolean('is_mandatory')->default(true);
                $table->timestamps();
            });
        }

        // 3. Create verification_logs table
        if (!Schema::hasTable('verification_logs')) {
            Schema::create('verification_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('document_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Staff/Admin who verified
                $table->string('previous_status')->nullable();
                $table->string('new_status');
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }

        // 4. Create generated_documents table
        if (!Schema::hasTable('generated_documents')) {
            Schema::create('generated_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
                $table->string('type'); // e.g., 'Admission Letter'
                $table->string('file_path');
                $table->timestamp('generated_at')->useCurrent();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_documents');
        Schema::dropIfExists('verification_logs');
        Schema::dropIfExists('required_documents');
        
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }
};
