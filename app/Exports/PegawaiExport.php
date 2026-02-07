<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PegawaiExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pegawai::with(['department', 'jabatans'])->get();
    }

    public function headings(): array
    {
        return [
            'ID Pegawai',
            'Nama',
            'NIK',
            'Departemen',
            'Jabatan',
            'Tanggal Masuk',
            'Status',
        ];
    }

    public function map($pegawai): array
    {
        return [
            $pegawai->employee_id,
            $pegawai->nama_pegawai,
            $pegawai->nik,
            $pegawai->department->name ?? '-',
            $pegawai->jabatans->nama_jabatan ?? '-',
            $pegawai->tanggal_masuk,
            $pegawai->status,
        ];
    }
}
