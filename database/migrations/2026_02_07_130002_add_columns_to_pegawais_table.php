<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->unsignedBigInteger('department_id')->nullable()->after('jabatan_id');
            $table->string('employee_id', 20)->unique()->nullable()->after('id');
            $table->string('nik', 16)->nullable()->after('nama_pegawai');
            $table->date('tanggal_lahir')->nullable()->after('nik');
            $table->enum('gender', ['L', 'P'])->nullable()->after('tanggal_lahir');
            $table->string('email', 100)->nullable()->after('telepon');
            $table->date('tanggal_masuk')->nullable()->after('email');
            $table->enum('status', ['aktif', 'cuti', 'resign', 'pensiun'])->default('aktif')->after('tanggal_masuk');
            $table->decimal('gaji_pokok', 15, 2)->default(0)->after('status');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['department_id']);
            $table->dropColumn([
                'user_id', 'department_id', 'employee_id', 'nik',
                'tanggal_lahir', 'gender', 'email', 'tanggal_masuk',
                'status', 'gaji_pokok'
            ]);
        });
    }
};
