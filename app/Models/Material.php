<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{

    protected $fillable = [
        'title',
        'description',
        'subject_id',
        'teacher_id',
        'class_id',
        'file_path',
        'file_type',
        'file_name',
        'file_size',
        'mime_type',
        'is_public',
    ];

    protected $casts = [
        //
    ];


    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(\App\Models\SchoolClass::class);
    }
}
