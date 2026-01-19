<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentAudit extends Model
{
    protected $fillable = [
        'document_id',
        'changed_by_user_id',
        'previous_status',
        'new_status',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }
}
