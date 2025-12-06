<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'name',
        'description',
        'subject_id',
        'school_class_id',
        'teacher_id',
        'exam_date',
        'start_time',
        'end_time',
        'total_score',
        'publish',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'total_score' => 'decimal:2',
        'publish' => 'boolean',
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
