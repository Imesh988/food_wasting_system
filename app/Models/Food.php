<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    //
     public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'food';
    use HasFactory;
    protected $fillable = ['name','owner_phone','expiry_date','quantity','notes'];

   
}
