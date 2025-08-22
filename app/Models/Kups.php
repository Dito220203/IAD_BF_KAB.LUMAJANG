<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Kups extends Model
{
    use HasFactory;
    protected $table = 'kups';
    protected $fillable = ['id_pengguna', 'id_kth', 'kups', 'pendapatan'];

    public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
    public function kth()
    {
        return $this->belongsTo(Kth::class, 'id_kth','id');
    }
}
