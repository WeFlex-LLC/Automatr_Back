<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = ['name','url','icon'];
    protected $casts = [
        'related' => 'array'
    ];

    public function automations () {
        
        return $this->hasMany(Automations::class);
    }

    public function limitRelationship(string $name, int $limit)
    {
        $this->relations[$name] = $this->relations[$name]->slice(0, $limit);
    }
    
}
