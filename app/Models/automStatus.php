<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class automStatus extends Model
{
    use HasFactory;

    public function automation () {
        return $this->belongsTo(Automations::class,'autom_id','id');
    }
}
