<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/migrate', function () {
    $token = env('MIGRATE_TOKEN');
    
    if (!$token || request('token') !== $token) {
        abort(403, 'Unauthorized');
    }

    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    
    return 'Migration completed: ' . nl2br(\Illuminate\Support\Facades\Artisan::output());
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', App\Http\Controllers\AdminController::class);
    Route::resource('categories', App\Http\Controllers\CategoryController::class)->except(['create', 'show', 'edit']);
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    
    // Academic Records
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::get('/grades', [App\Http\Controllers\Admin\GradeController::class, 'index'])->name('grades.index');
    Route::post('/grades', [App\Http\Controllers\Admin\GradeController::class, 'store'])->name('grades.store');
    
    // Attendance
    Route::get('/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [App\Http\Controllers\Admin\AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'store'])->name('attendance.store');

    // Fees
    Route::resource('fees', App\Http\Controllers\Admin\FeeController::class);
    Route::post('/fees/{fee}/payments', [App\Http\Controllers\Admin\FeeController::class, 'storePayment'])->name('fees.payments.store');
    
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\StudentController::class, 'index'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::middleware(['check.fees'])->group(function () {
        // Document Generation
        Route::get('/documents/admission-letter', [App\Http\Controllers\Student\DocumentGenerationController::class, 'admissionLetter'])->name('documents.admission_letter');
        Route::get('/documents/transcript/download', [App\Http\Controllers\Student\DocumentGenerationController::class, 'transcript'])->name('documents.transcript_download');
        Route::get('/documents/id-card', [App\Http\Controllers\Student\DocumentGenerationController::class, 'idCard'])->name('documents.id_card');
        Route::get('/documents/certificate', [App\Http\Controllers\Student\DocumentGenerationController::class, 'certificate'])->name('documents.certificate');
        
        // Download Routes
        Route::get('/documents/admission-letter/download', [App\Http\Controllers\Student\DocumentGenerationController::class, 'downloadAdmissionLetter'])->name('documents.admission_letter.download');
        Route::get('/documents/id-card/download', [App\Http\Controllers\Student\DocumentGenerationController::class, 'downloadIDCard'])->name('documents.id_card.download');
        Route::get('/documents/certificate/download', [App\Http\Controllers\Student\DocumentGenerationController::class, 'downloadCertificate'])->name('documents.certificate.download');

        Route::resource('documents', App\Http\Controllers\DocumentController::class);
    });

    Route::get('/transcript', [App\Http\Controllers\Student\TranscriptController::class, 'index'])->name('transcript');
    
    // Fees
    Route::get('/fees', [App\Http\Controllers\Student\FeeController::class, 'index'])->name('fees.index');
    Route::post('/fees/{fee}/pay', [App\Http\Controllers\Student\FeeController::class, 'pay'])->name('fees.pay');
});

Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\VerificationController::class, 'index'])->name('dashboard');
    Route::get('/students/{id}', [App\Http\Controllers\VerificationController::class, 'showStudent'])->name('student.show');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/documents/{id}/verify', [App\Http\Controllers\VerificationController::class, 'show'])->name('documents.show');
    Route::put('/documents/{id}/verify', [App\Http\Controllers\VerificationController::class, 'update'])->name('documents.update');
});
