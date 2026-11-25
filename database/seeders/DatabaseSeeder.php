<?php

namespace Database\Seeders;

use App\Models\MahasiswaLatih;
use App\Models\MahasiswaTarget;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@prodi.ac.id'],
            [
                'name' => 'Administrator Prodi SI',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $dosen = User::updateOrCreate(
            ['email' => 'dosen@prodi.ac.id'],
            [
                'name' => 'Dosen Wali / Pembimbing',
                'password' => Hash::make('dosen123'),
                'role' => 'dosen',
            ]
        );

        $dataLatihAwal = [
            ['nim' => '2022001', 'nama' => 'Alumni A', 'angkatan' => 2022, 'ipk' => 3.55, 'sks_diambil' => 144, 'sks_lulus' => 144, 'jumlah_e' => 0, 'jumlah_d_cd' => 0, 'jumlah_c' => 1, 'rata_rata_inti' => 3.50, 'status_kelulusan' => 1],
            ['nim' => '2022002', 'nama' => 'Alumni B', 'angkatan' => 2022, 'ipk' => 3.30, 'sks_diambil' => 144, 'sks_lulus' => 140, 'jumlah_e' => 0, 'jumlah_d_cd' => 1, 'jumlah_c' => 3, 'rata_rata_inti' => 3.25, 'status_kelulusan' => 1],
            ['nim' => '2022003', 'nama' => 'Mahasiswa C', 'angkatan' => 2022, 'ipk' => 2.45, 'sks_diambil' => 144, 'sks_lulus' => 112, 'jumlah_e' => 2, 'jumlah_d_cd' => 5, 'jumlah_c' => 6, 'rata_rata_inti' => 2.30, 'status_kelulusan' => 0],
            ['nim' => '2022004', 'nama' => 'Mahasiswa D', 'angkatan' => 2022, 'ipk' => 2.65, 'sks_diambil' => 144, 'sks_lulus' => 120, 'jumlah_e' => 1, 'jumlah_d_cd' => 4, 'jumlah_c' => 5, 'rata_rata_inti' => 2.50, 'status_kelulusan' => 0],
        ];

        foreach ($dataLatihAwal as $row) {
            MahasiswaLatih::updateOrCreate(['nim' => $row['nim']], $row);
        }

        $dataTargetAwal = [
            ['nim' => '2023001', 'nama' => 'Mahasiswa 2023 A', 'angkatan' => 2023, 'dosen_wali_id' => $dosen->id, 'ipk' => 3.45, 'sks_diambil' => 120, 'sks_lulus' => 118, 'jumlah_e' => 0, 'jumlah_d_cd' => 0, 'jumlah_c' => 2, 'rata_rata_inti' => 3.40],
            ['nim' => '2023002', 'nama' => 'Mahasiswa 2023 B', 'angkatan' => 2023, 'dosen_wali_id' => $dosen->id, 'ipk' => 2.75, 'sks_diambil' => 120, 'sks_lulus' => 102, 'jumlah_e' => 1, 'jumlah_d_cd' => 3, 'jumlah_c' => 5, 'rata_rata_inti' => 2.65],
        ];

        foreach ($dataTargetAwal as $row) {
            MahasiswaTarget::updateOrCreate(['nim' => $row['nim']], $row);
        }
    }
}