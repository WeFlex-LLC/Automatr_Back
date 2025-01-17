<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $primaryKey = 'id';

    protected $fillable = ['url','shortDescription','thumbnail','coverPhoto','content'];
    protected $casts = [
        'tags' => 'array'
    ];

    public function tags () {
        return $this->hasMany(Tag::class,'id','tags');
    }

}
