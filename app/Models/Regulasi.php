<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Regulasi extends Model
{
    use HasFactory;
    protected $table = 'regulasis';
    protected $fillable = ['judul','tanggal','status','file'];
}
