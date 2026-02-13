<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'type',
        'amount',
        'date_paid',
        'tax_deduction',
        'salary_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_deduction' => 'decimal:2',
        'date_paid' => 'date',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function salary(): BelongsTo
    {
        return $this->belongsTo(Salary::class);
    }
}
