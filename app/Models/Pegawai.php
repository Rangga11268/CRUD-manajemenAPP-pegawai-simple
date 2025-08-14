<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pegawai',
        'alamat',
        'telepon',
        'jabatan_id',
        'image',
    ];

    /**
     * Get the user that owns the Pegawai
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jabatans(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
