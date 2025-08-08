<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Pengguna extends Model
{
    use HasFactory;
    protected $table = 'peggunas';
    protected $fillable = ['username','password','nama','perangkat','level'];
}
