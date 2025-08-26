<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoProgres extends Model
{
    use HasFactory;
    protected $table = 'foto_progres';
    protected $fillable = ['id_progres','id_pengguna', 'foto'];

      public function progres()
    {
        return $this->belongsTo(ProgresKerja::class, 'id_progres','id');
    }

      public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
}
