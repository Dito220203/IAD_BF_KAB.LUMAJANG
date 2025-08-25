<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Potensi extends Model
{
    use HasFactory;
    protected $table = 'potensis';
    protected $fillable = ['id_pengguna','judul','kecamatan','desa','gambar','tanggal','uraian'];

      public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
}
