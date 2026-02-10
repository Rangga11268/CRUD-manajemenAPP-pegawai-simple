<?php

namespace App\Exports;

use App\Models\Salary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalaryExport implements FromCollection, WithHeadings, WithMapping
{
    protected $periode;
    protected $department_id;

    public function __construct($periode = null, $department_id = null)
    {
        $this->periode = $periode;
        $this->department_id = $department_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Salary::with(['pegawai.department', 'pegawai.jabatans']);

        if ($this->periode) {
            $query->where('periode', $this->periode);
        }

        if ($this->department_id) {
            $query->whereHas('pegawai', function($q) {
                $q->where('department_id', $this->department_id);
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID Pegawai',
            'Nama Pegawai',
            'Jabatan',
            'Departemen',
            'Periode',
            'Gaji Pokok',
            'Total Tunjangan',
            'Total Potongan',
            'Gaji Bersih',
            'Tanggal Bayar',
            'Status',
        ];
    }

    public function map($salary): array
    {
        return [
            $salary->pegawai->employee_id,
            $salary->pegawai->nama_pegawai,
            $salary->pegawai->jabatans->nama_jabatan ?? '-',
            $salary->pegawai->department->name ?? '-',
            $salary->periode,
            $salary->gaji_pokok,
            $salary->total_tunjangan,
            $salary->total_potongan,
            $salary->gaji_bersih,
            $salary->tanggal_bayar,
            $salary->status,
        ];
    }
}
