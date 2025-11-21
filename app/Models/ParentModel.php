<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ParentModel extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'relationship',
        'photo'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}
