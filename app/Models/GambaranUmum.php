<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class GambaranUmum extends Model
{
    use HasFactory;
    protected $table = 'gambaran_umums';
    protected $fillable = ['id_pengguna','judul','uraian','status'];

     public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
}
