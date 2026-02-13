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
        Schema::table('pegawais', function (Blueprint $table) {
            $table->enum('status_pernikahan', ['lajang', 'menikah', 'janda/duda'])->default('lajang')->after('status');
            $table->integer('jumlah_tanggungan')->default(0)->after('status_pernikahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn(['status_pernikahan', 'jumlah_tanggungan']);
        });
    }
};
