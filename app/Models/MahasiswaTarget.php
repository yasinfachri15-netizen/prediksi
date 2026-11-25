<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MahasiswaTarget extends Model
{
    protected $table = 'mahasiswa_target';

    protected $fillable = [
        'nim', 'nama', 'angkatan', 'dosen_wali_id', 'ipk',
        'sks_diambil', 'sks_lulus', 'jumlah_e', 'jumlah_d_cd',
        'jumlah_c', 'rata_rata_inti',
    ];

    public function dosenWali()
    {
        return $this->belongsTo(User::class, 'dosen_wali_id');
    }

    public function getRasioSksLulusAttribute(): float
    {
        if ((int) $this->sks_diambil <= 0) {
            return 0.0;
        }
        return round(min((float) $this->sks_lulus / (float) $this->sks_diambil, 1.0), 2);
    }
}