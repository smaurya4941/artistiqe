<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    protected $fillable = [
        'artist_id',
        'title',
        'year',
        'description',
        'category',
        'medium',
        'orientation',
        'width',
        'height',
        'depth',
        'primary_image',
        'angle_images',
        'delivery_type',
        'packaging_notes',
        'price',
        'commission',
        'gst',
        'earn',
        'status',
    ];

    /* ================= RELATIONS ================= */
protected $casts = [
        'angle_images' => 'array',
    ];
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    
}
