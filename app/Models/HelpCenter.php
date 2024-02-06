<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpCenter extends Model
{
    use HasFactory;

    protected $table = 'help_centers';

    protected $primaryKey = 'id';

    protected $fillable = ['question','answer'];
}
