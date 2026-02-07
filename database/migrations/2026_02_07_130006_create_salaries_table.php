<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->string('periode', 7); // Format: 2026-02
            $table->decimal('gaji_pokok', 15, 2);
            $table->decimal('total_tunjangan', 15, 2)->default(0);
            $table->decimal('total_potongan', 15, 2)->default(0);
            $table->decimal('gaji_bersih', 15, 2);
            $table->enum('status', ['draft', 'processed', 'paid'])->default('draft');
            $table->date('tanggal_bayar')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('pegawai_id')->references('id')->on('pegawais')->onDelete('cascade');
            $table->unique(['pegawai_id', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
