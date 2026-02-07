<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Run seeders in order
        $this->call([
            RolePermissionSeeder::class,
            DepartmentSeeder::class,
            LeaveTypeSeeder::class,
            JabatanSeeder::class,
        ]);

        // 1. Create ADMIN (Super Admin)
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');

        // Link Admin to Pegawai (Direktur Utama)
        $jabatanDirektur = Jabatan::where('nama_jabatan', 'Direktur Utama')->first();
        $deptBoard = Department::where('name', 'Board of Directors')->first() ?? Department::first();

        Pegawai::create([
            'user_id' => $admin->id,
            'department_id' => $deptBoard->id,
            'jabatan_id' => $jabatanDirektur->id,
            'nama_pegawai' => 'Administrator',
            'nik' => '1111111111111111',
            'employee_id' => 'DO001',
            'gender' => 'L',
            'tanggal_lahir' => '1980-01-01',
            'alamat' => 'Jakarta Pusat',
            'telepon' => '081234567890',
            'email' => 'admin@gmail.com',
            'tanggal_masuk' => '2020-01-01',
            'status' => 'aktif',
            'gaji_pokok' => 25000000,
            'image' => 'uploads/pegawai/default.png',
        ]);

        // 2. Create HR MANAGER
        $hr = User::create([
            'name' => 'HR Manager',
            'email' => 'hr@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'hr',
        ]);
        $hr->assignRole('hr');

        $jabatanHR = Jabatan::where('nama_jabatan', 'Manager HR')->first();
        $deptHR = Department::where('name', 'Human Resources')->first() ?? Department::first();

        Pegawai::create([
            'user_id' => $hr->id,
            'department_id' => $deptHR->id,
            'jabatan_id' => $jabatanHR->id,
            'nama_pegawai' => 'HR Manager',
            'nik' => '2222222222222222',
            'employee_id' => 'HR001',
            'gender' => 'P',
            'tanggal_lahir' => '1985-05-05',
            'alamat' => 'Jakarta Selatan',
            'telepon' => '081298765432',
            'email' => 'hr@gmail.com',
            'tanggal_masuk' => '2021-02-01',
            'status' => 'aktif',
            'gaji_pokok' => 15000000,
            'image' => 'uploads/pegawai/default.png',
        ]);

        // 3. Create PROJECT MANAGER
        $manager = User::create([
            'name' => 'IT Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);
        $manager->assignRole('manager');

        $jabatanManager = Jabatan::where('nama_jabatan', 'Manager IT')->first();
        $deptIT = Department::where('name', 'Information Technology')->first() ?? Department::first();

        Pegawai::create([
            'user_id' => $manager->id,
            'department_id' => $deptIT->id,
            'jabatan_id' => $jabatanManager->id,
            'nama_pegawai' => 'IT Manager',
            'nik' => '3333333333333333',
            'employee_id' => 'IT001',
            'gender' => 'L',
            'tanggal_lahir' => '1988-08-08',
            'alamat' => 'Bandung',
            'telepon' => '081211223344',
            'email' => 'manager@gmail.com',
            'tanggal_masuk' => '2021-03-01',
            'status' => 'aktif',
            'gaji_pokok' => 15000000,
            'image' => 'uploads/pegawai/default.png',
        ]);

        // 4. Create PEGAWAI (Staff)
        $staff = User::create([
            'name' => 'Warga Biasa',
            'email' => 'pegawai@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
        ]);
        $staff->assignRole('pegawai');

        $jabatanStaff = Jabatan::where('nama_jabatan', 'Staff IT')->first();

        Pegawai::create([
            'user_id' => $staff->id,
            'department_id' => $deptIT->id,
            'jabatan_id' => $jabatanStaff->id,
            'nama_pegawai' => 'Warga Biasa',
            'nik' => '4444444444444444',
            'employee_id' => 'IT002',
            'gender' => 'L',
            'tanggal_lahir' => '1995-12-12',
            'alamat' => 'Yogyakarta',
            'telepon' => '081255667788',
            'email' => 'pegawai@gmail.com',
            'tanggal_masuk' => '2022-01-01',
            'status' => 'aktif',
            'gaji_pokok' => 8000000,
            'image' => 'uploads/pegawai/default.png',
        ]);
    }
}
