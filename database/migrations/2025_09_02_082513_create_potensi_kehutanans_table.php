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
        Schema::create('potensi_kehutanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->references('id')->on('penggunas')->onDelete('cascade');
            $table->foreignId('id_subpotensi')->references('id')->on('subpotensi_kehutanans')->onDelete('cascade');
            $table->string('gambar');
            $table->longText('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potensi_kehutanans');

    }
};
