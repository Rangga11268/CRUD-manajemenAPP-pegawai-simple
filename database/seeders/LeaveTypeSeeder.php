<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            [
                'nama' => 'Cuti Tahunan',
                'max_days' => 12,
                'description' => 'Cuti tahunan yang diberikan kepada pegawai',
                'is_paid' => true,
            ],
            [
                'nama' => 'Cuti Sakit',
                'max_days' => 14,
                'description' => 'Cuti karena sakit dengan surat keterangan dokter',
                'is_paid' => true,
            ],
            [
                'nama' => 'Cuti Melahirkan',
                'max_days' => 90,
                'description' => 'Cuti melahirkan untuk pegawai perempuan',
                'is_paid' => true,
            ],
            [
                'nama' => 'Cuti Menikah',
                'max_days' => 3,
                'description' => 'Cuti untuk pernikahan pegawai',
                'is_paid' => true,
            ],
            [
                'nama' => 'Cuti Duka',
                'max_days' => 3,
                'description' => 'Cuti karena keluarga meninggal dunia',
                'is_paid' => true,
            ],
            [
                'nama' => 'Izin Tidak Hadir',
                'max_days' => 5,
                'description' => 'Izin tidak masuk kerja tanpa gaji',
                'is_paid' => false,
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::create($leaveType);
        }
    }
}
