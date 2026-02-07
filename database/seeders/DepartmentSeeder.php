<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Direksi',
                'code' => 'DIR',
                'description' => 'Jajaran Direksi Perusahaan',
            ],
            [
                'name' => 'Human Resources',
                'code' => 'HRD',
                'description' => 'Departemen Sumber Daya Manusia',
            ],
            [
                'name' => 'Keuangan',
                'code' => 'FIN',
                'description' => 'Departemen Keuangan dan Akuntansi',
            ],
            [
                'name' => 'IT',
                'code' => 'IT',
                'description' => 'Departemen Teknologi Informasi',
            ],
            [
                'name' => 'Operasional',
                'code' => 'OPS',
                'description' => 'Departemen Operasional',
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Departemen Pemasaran',
            ],
            [
                'name' => 'Produksi',
                'code' => 'PRD',
                'description' => 'Departemen Produksi',
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
