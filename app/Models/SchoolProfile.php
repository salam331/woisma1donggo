<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'principal_name',
        'description',
        'logo',
        'vision',
        'mission',
        'history',
    ];
}
