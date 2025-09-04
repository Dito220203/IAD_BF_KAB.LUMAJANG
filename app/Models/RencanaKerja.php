<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class RencanaKerja extends Model
{
    use HasFactory;
    protected $table = 'rencana_kerjas';
    protected $fillable = ['id_pengguna','id_subprogram','id_opd','judul','lokasi','tanggal','anggaran','status','keterangan'];

    public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
    public function subprogram()
    {
        return $this->belongsTo(Subprogram::class, 'id_subprogram', 'id');
    }
    public function opd()
    {
        return $this->belongsTo(Opd::class, 'id_opd', 'id');
    }
     public function monev()
    {
        return $this->hasMany(Monev::class, 'id_renja', 'id');
    }
}

