<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubpotensiKehutanan extends Model
{
    use HasFactory;
    protected $table = 'subpotensi_kehutanans';
    protected $fillable = ['id_pengguna', 'sub_potensi', 'keterangan','delete_at'];

    public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
    public function potensis()
    {
        return $this->hasMany(Potensi::class, 'id_subpotensi', 'id');
    }
}
