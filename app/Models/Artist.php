<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Artist profile — a 1:1 extension of a `users` row (user_type = 'artist').
 * Authentication happens against the users table, not this model.
 */
class Artist extends Model
{
    use HasFactory;

    protected $table = 'artists';

    protected $fillable = [
        'user_id',
        'first_name', 'last_name', 'email', 'phone',
        'address1', 'address2', 'city', 'state', 'country', 'pincode',
        'college', 'degree', 'portfolio', 'journey',
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

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
