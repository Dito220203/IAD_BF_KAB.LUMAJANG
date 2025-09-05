<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Monev extends Model
{
    use HasFactory;
    protected $table = 'monevs';
    protected $fillable = [
        'id_pengguna',
        'id_subprogram',
        'id_renja',
        'lokasi',
        'tahun',
        'anggaran',
        'id_opd',
        'rka',
        'realisasi',
        'keterangan'
    ];

    public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
       public function subprogram()
    {
        return $this->belongsTo(Subprogram::class, 'id_subprogram', 'id');
    }

    public function rencanaKerja()
    {
        return $this->belongsTo(RencanaKerja::class, 'id_renja', 'id');
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'id_opd', 'id');
    }

}
