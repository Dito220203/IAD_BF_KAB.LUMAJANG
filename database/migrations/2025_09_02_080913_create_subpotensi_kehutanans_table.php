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
        Schema::create('subpotensi_kehutanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->references('id')->on('penggunas')->onDelete('cascade');
            $table->string('sub_potensi');
            $table->longText('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subpotensi_kehutanans');
    }
};
