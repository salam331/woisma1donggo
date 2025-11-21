<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'email',
        'phone',
        'address',
        'birth_date',
        'gender',
        'subject_specialization',
        'photo',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClasses(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'teacher_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'marked_by');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
