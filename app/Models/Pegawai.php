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
        'status_pernikahan',
        'jumlah_tanggungan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'gaji_pokok' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama_pegawai', 'jabatan_id', 'department_id', 'status', 'gaji_pokok', 'status_pernikahan', 'jumlah_tanggungan'])
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

    // TER Categories:
    // A: TK/0 (0), TK/1 (0), K/0 (0) -> Wait, logic:
    // TK/0 = A
    // TK/1 = A
    // K/0 = A
    // TK/2 = B
    // TK/3 = B
    // K/1 = B
    // K/2 = B
    // K/3 = C
    public function getPtkpCategoryAttribute(): string
    {
        $status = $this->status_pernikahan; // lajang, menikah, janda/duda
        $tanggungan = $this->jumlah_tanggungan;

        // Normalize status
        // Lajang/Janda/Duda = TK (Tidak Kawin) effectively for tax unless specified otherwise?
        // Actually Janda/Duda is usually treated as TK unless they have dependents?
        // Allow simplification:
        // 'lajang' -> TK
        // 'janda/duda' -> TK
        // 'menikah' -> K

        $kodeStatus = ($status === 'menikah') ? 'K' : 'TK';
        
        // PTKP Map to TER
        // Source: PP 58 Tahun 2023
        // A: TK/0, TK/1, K/0
        // B: TK/2, TK/3, K/1, K/2
        // C: K/3

        if ($kodeStatus === 'TK') {
            if ($tanggungan == 0 || $tanggungan == 1) return 'A';
            if ($tanggungan == 2 || $tanggungan == 3) return 'B';
        } elseif ($kodeStatus === 'K') {
            if ($tanggungan == 0) return 'A';
            if ($tanggungan == 1 || $tanggungan == 2) return 'B';
            if ($tanggungan >= 3) return 'C';
        }

        return 'A'; // Default fallback
    }
}
