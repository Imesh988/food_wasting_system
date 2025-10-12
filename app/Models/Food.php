<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    //
    protected $fillable = ['name','user_id','owner_phone','expiry_date','quantity','notes'];

    protected $casts = [
        'expiry_date' => 'date',
    ];
}
