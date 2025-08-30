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
            $table->unsignedBigInteger('id_renja')->nullable();
            $table->foreign('id_renja')
                ->references('id')
                ->on('rencana_kerjas')
                ->onDelete('cascade');
            $table->string('lokasi')->nullable();
            $table->string('tahun')->nullable();
            $table->string('anggaran')->nullable();
            $table->unsignedBigInteger('id_opd')->nullable();
            $table->foreign('id_opd')
                ->references('id')
                ->on('opds')
                ->onDelete('set null');

            $table->string('rka')->nullable();
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
