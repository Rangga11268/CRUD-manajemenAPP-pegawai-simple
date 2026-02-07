<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_id',
        'nama',
        'type',
        'jumlah',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function salary(): BelongsTo
    {
        return $this->belongsTo(Salary::class);
    }

    public function scopeTunjangan($query)
    {
        return $query->where('type', 'tunjangan');
    }

    public function scopePotongan($query)
    {
        return $query->where('type', 'potongan');
    }
}
