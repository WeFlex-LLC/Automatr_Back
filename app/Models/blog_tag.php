<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blog_tag extends Model
{
    use HasFactory;
    protected $table = 'blog_tags';

    protected $primaryKey = 'id';

    protected $fillable = ['blog_id','tag_id'];


}
