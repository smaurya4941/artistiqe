<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Gallery profile — a 1:1 extension of a `users` row (user_type = 'gallery').
 * Authentication happens against the users table, not this model.
 */
class GalleryRegister extends Model
{
    use HasFactory;

    protected $table = 'gallery_registers';

    protected $fillable = [
        'user_id',
        'owner_name', 'owner_surname', 'email', 'phone',
        'gallery_name', 'address1', 'address2', 'city', 'state', 'country', 'pincode', 'website',
        'curatorial_vision', 'exhibition_types', 'past_links', 'sell_interest',
        'status', 'approved_at', 'reviewed_by', 'rejection_reason',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->owner_name} {$this->owner_surname}");
    }
}
