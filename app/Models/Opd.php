<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Opd extends Model
{
    use HasFactory;
    protected $table = 'opds';
    protected $fillable = ['nama', 'status'];

     public function penggunas()
    {
        return $this->hasMany(Pengguna::class, 'id_opd', 'id');
    }
     public function rencana_kerjas()
    {
        return $this->hasMany(RencanaKerja::class, 'id_opd', 'id');
    }

     public function monev()
    {
        return $this->hasMany(Monev::class, 'id_opd', 'id');
    }
}
