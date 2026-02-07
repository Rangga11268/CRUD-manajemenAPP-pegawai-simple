<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $jabatans = [
            [
                'nama_jabatan' => 'Direktur Utama',
                'deskripsi_jabatan' => 'Leader of the company',
            ],
            [
                'nama_jabatan' => 'Manager HR',
                'deskripsi_jabatan' => 'Manages HR department',
            ],
            [
                'nama_jabatan' => 'Manager IT',
                'deskripsi_jabatan' => 'Manages IT department',
            ],
            [
                'nama_jabatan' => 'Manager Finance',
                'deskripsi_jabatan' => 'Manages finance department',
            ],
            [
                'nama_jabatan' => 'Senior Developer',
                'deskripsi_jabatan' => 'Develops core systems',
            ],
            [
                'nama_jabatan' => 'Staff HR',
                'deskripsi_jabatan' => 'Human resources staff',
            ],
            [
                'nama_jabatan' => 'Staff IT',
                'deskripsi_jabatan' => 'IT support staff',
            ],
            [
                'nama_jabatan' => 'Staff Admin',
                'deskripsi_jabatan' => 'Administrative staff',
            ],
        ];

        foreach ($jabatans as $jabatan) {
            Jabatan::create($jabatan);
        }
    }
}
