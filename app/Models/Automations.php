<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Automations extends Model
{
    use HasFactory;

    protected $table = 'automations';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'h1', 'text1','h2','text2','h3','text3','tutorial','updates','category_id','type_id'];

    protected $hidden = ['api'];

    protected $casts = [
        'input' => 'array',
        'inputName' => 'array',
        'inputTab' => 'array',
        'tabName' => 'array',
        'tabText' => 'array',
        'related' => 'array'
    ];

    public function category () {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function automationType () {
        return $this->belongsTo(Type::class,'type_id');
    }

    public function automationStatus () {
        return $this->hasMany(automStatus::class,'autom_id');
    }
}
