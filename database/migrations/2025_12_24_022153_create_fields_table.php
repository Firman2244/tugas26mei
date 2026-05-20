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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lapangan');
            $table->enum('tipe_lapangan', ['Matras', 'Sintetis', 'Vintl']);
            $table->enum('ukuran_lapangan', ['Besar', 'Sedang', 'Kecil']);
            $table->integer('harga_per_jam');
            $table->string('image_url')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
