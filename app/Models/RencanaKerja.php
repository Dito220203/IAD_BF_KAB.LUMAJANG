<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class RencanaKerja extends Model
{
    use HasFactory;
    protected $table = 'rencana_kerjas';
    protected $fillable = ['subprogram','judul','status','file'];
}
