<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subsribtion extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
    ];
}
