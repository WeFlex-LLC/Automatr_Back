<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Automations;

class Type extends Model
{
    use HasFactory;

    protected $table = 'type';

    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public function automationType () {
        return $this->hasMany(Automations::class);
    }
}
