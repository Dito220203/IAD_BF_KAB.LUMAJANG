<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKups extends Model
{
    Use HasFactory;
    protected $table = 'produk_kups';
    protected $fillable = ['id_pengguna','nama','gambar','keterangan'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
