<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Salary extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'pegawai_id',
        'periode',
        'gaji_pokok',
        'total_tunjangan',
        'total_potongan',
        'gaji_bersih',
        'status',
        'tanggal_bayar',
        'catatan',
    ];

    protected $casts = [
        'gaji_pokok' => 'decimal:2',
        'total_tunjangan' => 'decimal:2',
        'total_potongan' => 'decimal:2',
        'gaji_bersih' => 'decimal:2',
        'tanggal_bayar' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'tanggal_bayar'])
            ->logOnlyDirty();
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function components(): HasMany
    {
        return $this->hasMany(SalaryComponent::class);
    }

    public function tunjangan(): HasMany
    {
        return $this->hasMany(SalaryComponent::class)->where('type', 'tunjangan');
    }

    public function potongan(): HasMany
    {
        return $this->hasMany(SalaryComponent::class)->where('type', 'potongan');
    }

    public function calculateTotal(): void
    {
        $this->total_tunjangan = $this->tunjangan()->sum('jumlah');
        $this->total_potongan = $this->potongan()->sum('jumlah');
        $this->gaji_bersih = $this->gaji_pokok + $this->total_tunjangan - $this->total_potongan;
        $this->save();
    }
}
