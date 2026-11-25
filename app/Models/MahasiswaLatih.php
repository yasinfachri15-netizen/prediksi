<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MahasiswaLatih extends Model
{
    protected $table = 'mahasiswa_latih';

    protected $fillable = [
        'nim', 'nama', 'angkatan', 'ipk', 'sks_diambil',
        'sks_lulus', 'jumlah_e', 'jumlah_d_cd', 'jumlah_c',
        'rata_rata_inti', 'status_kelulusan',
    ];
}