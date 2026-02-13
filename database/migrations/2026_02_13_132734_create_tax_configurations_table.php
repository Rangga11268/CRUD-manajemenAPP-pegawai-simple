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
        Schema::create('tax_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('category', 1); // A, B, C
            $table->decimal('min_gross', 15, 2);
            $table->decimal('max_gross', 15, 2)->nullable(); // Nullable for infinity
            $table->decimal('rate', 5, 4); // 0.0500 for 5%
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_configurations');
    }
};
