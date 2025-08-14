<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jabatan',
        'deskripsi_jabatan'
    ];

    /**
     * Get all of the comments for the Jabatan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pegawais(): HasMany
    {
        return $this->hasMany(Jabatan::class);
    }
}
