<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedDocument extends Model
{
    protected $fillable = [
        'student_id',
        'type',
        'file_path',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
