<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'promoCode',
        'package_id',
    ];

    
}
