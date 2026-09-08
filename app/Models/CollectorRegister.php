<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CollectorRegister extends Authenticatable
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'collector_registers';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        // Personal (MANDATORY)
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',

        // Address
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'zip',

        // Collector specific
        'journey',
        'sell_interest',
    ];

    /**
     * Hidden attributes (for security)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
