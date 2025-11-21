<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'title',
        'description',
        'subject_id',
        'school_class_id',
        'teacher_id',
        'exam_date',
        'exam_type',
        'total_score',
        'academic_year',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'total_score' => 'decimal:2',
        'academic_year' => 'integer',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
