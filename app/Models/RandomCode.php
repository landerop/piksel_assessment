<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RandomCode extends Model
{
    protected $fillable = ['code'];
    protected $table = 'random_code';
    use HasFactory;
}
