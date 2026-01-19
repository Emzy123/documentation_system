<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'file_path',
        'status',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function audits()
    {
        return $this->hasMany(DocumentAudit::class);
    }

    public function verificationLogs()
    {
        return $this->hasMany(VerificationLog::class);
    }
}
