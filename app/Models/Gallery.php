<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'image_name',
        'image_size',
        'mime_type',
        'uploaded_by',
        'is_active',
        'category',
        'event_date',
        'additional_images',
    ];

    protected $casts = [
        'image_size' => 'integer',
        'is_active' => 'boolean',
        'event_date' => 'date',
        'additional_images' => 'array',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
