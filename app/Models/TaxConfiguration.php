<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'min_gross',
        'max_gross',
        'rate',
    ];

    protected $casts = [
        'min_gross' => 'decimal:2',
        'max_gross' => 'decimal:2',
        'rate' => 'decimal:4',
    ];
}
