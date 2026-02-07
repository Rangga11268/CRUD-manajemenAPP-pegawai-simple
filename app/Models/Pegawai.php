<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pegawai extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'employee_id',
        'nama_pegawai',
        'nik',
        'tanggal_lahir',
        'gender',
        'alamat',
        'telepon',
        'email',
        'tanggal_masuk',
        'status',
        'gaji_pokok',
        'jabatan_id',
        'department_id',
        'image',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'gaji_pokok' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama_pegawai', 'jabatan_id', 'department_id', 'status', 'gaji_pokok'])
            ->logOnlyDirty();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jabatans(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->nama_pegawai;
    }

    public function getLeavesBalanceAttribute(): int
    {
        $usedLeaves = $this->leaves()
            ->where('status', 'approved')
            ->whereYear('start_date', now()->year)
            ->sum('days_count');
        
        return 12 - $usedLeaves; // Default 12 days annual leave
    }
}
