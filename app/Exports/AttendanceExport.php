<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendance::with('pegawai')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Pegawai',
            'Clock In',
            'Clock Out',
            'Status',
            'Keterangan',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->tanggal,
            $attendance->pegawai->nama_pegawai ?? '-',
            $attendance->clock_in,
            $attendance->clock_out,
            $attendance->status,
            $attendance->keterangan,
        ];
    }
}
