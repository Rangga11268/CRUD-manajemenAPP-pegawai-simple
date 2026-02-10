<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if email already exists
        if (User::where('email', $row['email'])->exists()) {
            return null;
        }

        // Create User
        $user = User::create([
            'name' => $row['nama_pegawai'],
            'email' => $row['email'], // Make sure Excel has 'email' column
            'password' => Hash::make($row['password'] ?? 'password'), // Default password
        ]);

        $user->assignRole('pegawai');

        // Lookup or Create Jabatan
        $jabatan = Jabatan::firstOrCreate(['nama_jabatan' => $row['jabatan']]);

        // Lookup or Create Department
        $department = Department::firstOrCreate(['nama_department' => $row['department']]);

        // Create Pegawai
        return new Pegawai([
            'user_id' => $user->id,
            'nama_pegawai' => $row['nama_pegawai'],
            'jenis_kelamin' => $row['jenis_kelamin'] ?? 'L', // L/P
            'alamat' => $row['alamat'] ?? '-',
            'no_hp' => $row['no_hp'] ?? '-',
            'jabatan_id' => $jabatan->id,
            'department_id' => $department->id,
            'tanggal_masuk' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_masuk']),
            'gaji_pokok' => $row['gaji_pokok'] ?? 0,
            'status' => 'aktif',
            'image' => 'uploads/pegawai/default.png',
        ]);
    }
}
