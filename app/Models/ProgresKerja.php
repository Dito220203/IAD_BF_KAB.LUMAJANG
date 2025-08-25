<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class ProgresKerja extends Model
{
    use HasFactory;
    protected $table = 'progres_kerjas';
    protected $fillable = ['id_subprogram', 'id_pengguna', 'judul', 'tahun', 'sumber_dana', 'jumlah_anggaran', 'penerima', 'uraian', 'status'];

    public function maps()
    {
        return $this->hasMany(Map::class, 'id_progres');
    }
    public function fotoProgres()
    {
        return $this->hasOne(FotoProgres::class, 'id_progres');
    }

    public function subprogram()
    {
        return $this->belongsTo(Subprogram::class, 'id_subprogram', 'id');
    }

    public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }

}
