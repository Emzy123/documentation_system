<?php

namespace App\Models;

use App\Models\User; // Assuming User model is in the same namespace
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'student_number',
        'program',
        'year_level',
        'date_of_birth',
        'gender',
        'contact_number',
        'address',
        'guardian_name',
        'guardian_contact',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function generatedDocuments()
    {
        return $this->hasMany(GeneratedDocument::class);
    }

    public function hasPaidSchoolFees()
    {
        // Check for any fee of type 'tuition' or 'school_fee' that is paid
        return $this->fees()
            ->whereIn('type', ['tuition', 'school_fee'])
            ->where('status', 'paid')
            ->exists();
    }
}
