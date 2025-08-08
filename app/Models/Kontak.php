<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Kontak extends Model
{
    use HasFactory;
    protected $table = 'kontaks';
    protected $fillable = ['telepon','email','namafb','linkfb','namaig','linkig','namayt','linkyt'];
}
