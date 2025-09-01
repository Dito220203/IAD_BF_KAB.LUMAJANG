<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    use HasFactory;
    protected $table = 'maps'; // pastikan sama dengan nama tabel di database
    protected $fillable = [
        'id_progres',
        'id_pengguna',
        'latitude',
        'longitude',
    ];

    public function progres()
    {
        return $this->belongsTo(ProgresKerja::class, 'id_progres', 'id');
    }
    public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }

}
