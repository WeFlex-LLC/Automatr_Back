<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class package_users extends Model
{
    use HasFactory;

    public function package (){
        return $this->hasOne(package::class,'id','package_id');
    }

    public function package_users (){
        return $this->hasOne(User::class,'id','user_id');
    }
}
