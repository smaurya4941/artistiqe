<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryRegister extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'gallery_registers';

    /**
     * Mass assignable fields
     */
    protected $fillable = [

        // Owner
        'owner_name',
        'owner_surname',
        'email',
        'phone',
        'password',

        // Gallery
        'gallery_name',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'pincode',
        'website',

        // Curatorial
        'curatorial_vision',

        // Exhibition
        'exhibition_types',
        'past_links',

        // Selling
        'sell_interest',
    ];
}
