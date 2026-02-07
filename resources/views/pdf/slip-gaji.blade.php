<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $salary->periode }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .salary-table th, .salary-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .salary-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .total-row {
            font-weight: bold;
            background-color: #e9e9e9;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 60px;
            border-top: 1px solid #333;
            display: inline-block;
            width: 200px;
            text-align: center;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SLIP GAJI</h1>
        <p>Manajemen Pegawai App</p>
        <p>Periode: {{ $salary->periode }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="20%">Nama</td>
            <td width="30%">: {{ $salary->pegawai->nama_pegawai }}</td>
            <td width="20%">ID Pegawai</td>
            <td width="30%">: {{ $salary->pegawai->employee_id }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: {{ $salary->pegawai->jabatan->nama_jabatan ?? '-' }}</td>
            <td>Departemen</td>
            <td>: {{ $salary->pegawai->user->department->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="salary-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th style="text-align: right;">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>A. PENGHASILAN</strong></td>
                <td></td>
            </tr>
            <tr>
                <td>Gaji Pokok</td>
                <td style="text-align: right;">{{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            
            @foreach($salary->components as $component)
                @if($component->type == 'tunjangan')
                <tr>
                    <td>{{ $component->nama }}</td>
                    <td style="text-align: right;">{{ number_format($component->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endif
            @endforeach

            <tr class="total-row">
                <td>Total Penghasilan Bruto</td>
                <td style="text-align: right;">{{ number_format($salary->gaji_pokok + $salary->total_tunjangan, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td><br><strong>B. POTONGAN</strong></td>
                <td></td>
            </tr>
            @foreach($salary->components as $component)
                @if($component->type == 'potongan')
                <tr>
                    <td>{{ $component->nama }}</td>
                    <td style="text-align: right;">{{ number_format($component->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endif
            @endforeach
            
            @if($salary->total_potongan == 0)
            <tr>
                <td>- Tidak ada potongan -</td>
                <td style="text-align: right;">0</td>
            </tr>
            @endif

            <tr class="total-row">
                <td>Total Potongan</td>
                <td style="text-align: right;">{{ number_format($salary->total_potongan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="total-row" style="background-color: #dff0d8;">
                <td>GAJI BERSIH (A - B)</td>
                <td style="text-align: right; font-size: 16px;">{{ number_format($salary->gaji_bersih, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Jakarta, {{ \Carbon\Carbon::parse($salary->tanggal_bayar)->format('d F Y') }}</p>
        <div class="signature">
            <p>Finance Manager</p>
        </div>
    </div>
</body>
</html>
