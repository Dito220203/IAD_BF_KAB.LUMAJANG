<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class LogAktivitas extends Model
{
    use HasFactory;
    protected $table = 'log_aktivitas';
    protected $fillable = ['id_pengguna', 'ip', 'waktu', 'aktivitas'];

     public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
