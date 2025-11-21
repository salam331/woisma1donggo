<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'credits',
        'teacher_id',
    ];

    protected $casts = [
        'credits' => 'integer',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
