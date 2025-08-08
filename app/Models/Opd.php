<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Opd extends Model
{
    use HasFactory;
    protected $table = 'opds';
    protected $fillable = ['nama','status'];
}
