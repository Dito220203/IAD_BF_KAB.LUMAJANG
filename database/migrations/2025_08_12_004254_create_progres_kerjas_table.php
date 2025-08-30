<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('progres_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_subprogram')->references('id')->on('subprograms')->onDelete('cascade');
            $table->foreignId('id_pengguna')->references('id')->on('penggunas')->onDelete('cascade');
            $table->string('judul');
            $table->string('tahun');
            $table->string('sumber_dana');
            $table->string('jumlah_anggaran');
            $table->string('penerima');
            $table->longText('uraian');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_kerjas');
    }
};
