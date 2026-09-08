<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Artist extends Authenticatable
{
    protected $table = 'artists';
    
    protected $fillable = [
        'first_name','last_name','email','phone','password',
        'address1','address2','city','state','country',
        'pincode','college','degree','portfolio','journey'
    ];
    protected $hidden = [
        'password',
    ];
}

