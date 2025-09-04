<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotensiKehutanan extends Model
{
    use HasFactory;
    protected $table = 'potensi_kehutanans';
    protected $fillable = [
        'id_pengguna',
        'id_subpotensi',
        'gambar',
        'keterangan'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
   public function SubpotensiKehutanan()
{
    return $this->belongsTo(SubpotensiKehutanan::class, 'id_subpotensi', 'id');
}

}
