<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Kth extends Model
{
    use HasFactory;
    protected $table = 'kths';
    protected $fillable = ['id_pengguna','kth','luas'];

     public function penggunas()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
     public function kups()
    {
        return $this->hasMany(Kups::class, 'id_kth', 'id');
    }
}
