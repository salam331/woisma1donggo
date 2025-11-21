<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'created_by',
        'publish_date',
        'is_active',
        'target',
        'image',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'is_active' => 'boolean',
    ];

    // public function schoolClass(): BelongsTo
    // {
    //     return $this->belongsTo(SchoolClass::class);
    // }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
