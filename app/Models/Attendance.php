<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Attendance extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'clock_in',
        'clock_out',
        'status',
        'keterangan',
        'clock_in_location',
        'clock_out_location',
        'latitude',
        'longitude',
        'address',
        'image_path',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'clock_in' => 'datetime:H:i:s',
        'clock_out' => 'datetime:H:i:s',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['clock_in', 'clock_out', 'status'])
            ->logOnlyDirty();
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function getWorkHoursAttribute(): ?string
    {
        if ($this->clock_in && $this->clock_out) {
            $diff = $this->clock_out->diff($this->clock_in);
            return $diff->format('%H:%I');
        }
        return null;
    }
}
