<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Collector profile — a 1:1 extension of a `users` row (user_type = 'collector').
 * Authentication happens against the users table, not this model.
 */
class CollectorRegister extends Model
{
    use HasFactory;

    protected $table = 'collector_registers';

    protected $fillable = [
        'user_id',
        'first_name', 'last_name', 'email', 'phone',
        'address_line1', 'address_line2', 'city', 'state', 'country', 'zip',
        'journey', 'sell_interest',
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
        return trim("{$this->first_name} {$this->last_name}");
    }
}
