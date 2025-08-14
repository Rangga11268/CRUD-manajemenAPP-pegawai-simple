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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pegawai', 255);
            $table->unsignedBigInteger('jabatan_id');
            $table->string('alamat', 255);
            $table->string('telepon', 20);
            $table->string('image', 255);
            $table->timestamps();

            $table->foreign('jabatan_id')->references('id')->on('jabatans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
