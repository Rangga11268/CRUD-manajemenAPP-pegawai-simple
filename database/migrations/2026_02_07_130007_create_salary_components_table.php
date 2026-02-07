<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_id');
            $table->string('nama', 100);
            $table->enum('type', ['tunjangan', 'potongan']);
            $table->decimal('jumlah', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('salary_id')->references('id')->on('salaries')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_components');
    }
};
