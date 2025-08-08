<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Video extends Model
{
    use HasFactory;
    protected $table = 'videos';
    protected $fillable = ['judul','link'];
}
