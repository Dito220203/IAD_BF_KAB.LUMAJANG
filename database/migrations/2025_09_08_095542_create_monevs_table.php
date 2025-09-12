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
        Schema::create('monevs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->references('id')->on('penggunas')->onDelete('cascade');
            $table->foreignId('id_subprogram')->references('id')->on('subprograms')->onDelete('cascade');
            $table->string('rencana_aksi');
            $table->string('sub_kegiatan');
            $table->longText('kegiatan');
            $table->string('nama_program');
            $table->string('lokasi');
            $table->string('volume');
            $table->string('satuan');
            $table->string('anggaran');
            $table->string('sumberdana');
            $table->string('tahun');
            $table->unsignedBigInteger('id_opd')->nullable();
            $table->foreign('id_opd')->references('id')->on('opds')->onDelete('set null');

            $table->string('rka')->nullable();
            $table->date('tanggal');
            $table->string('pesan')->nullable();

            $table->string('status')->default('tidak valid');
            $table->string('realisasi')->nullable();
            $table->longText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monevs');
    }
};
