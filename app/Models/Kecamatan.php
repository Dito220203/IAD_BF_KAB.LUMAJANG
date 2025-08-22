<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'kecamatans';
     protected $fillable = ['kode','kecamatan','jml_desa'];
}
