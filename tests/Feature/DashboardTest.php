<?php

namespace Tests\Feature;

use App\Models\MahasiswaTarget;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use DatabaseTransactions;

    public function test_dashboard_search_shows_empty_prediction_as_unavailable(): void
    {
        $admin = User::create([
            'name' => 'Admin Dashboard Test',
            'email' => 'dashboard-test-' . uniqid() . '@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $mahasiswa = MahasiswaTarget::create([
            'nim' => 'TEST-DASH-001',
            'nama' => 'Mahasiswa Dicari',
            'angkatan' => 2024,
            'ipk' => 3.25,
            'sks_diambil' => 100,
            'sks_lulus' => 90,
            'jumlah_e' => 0,
            'jumlah_d_cd' => 1,
            'jumlah_c' => 2,
            'rata_rata_inti' => 3.10,
        ]);
        MahasiswaTarget::create([
            'nim' => 'TEST-DASH-002',
            'nama' => 'Mahasiswa Lain',
            'angkatan' => 2024,
            'ipk' => 2.90,
            'sks_diambil' => 100,
            'sks_lulus' => 80,
            'jumlah_e' => 1,
            'jumlah_d_cd' => 2,
            'jumlah_c' => 3,
            'rata_rata_inti' => 2.80,
        ]);

        Http::fake([
            '*predict' => Http::response(['detail' => 'Model belum dilatih.'], 503),
        ]);

        $response = $this->actingAs($admin)->get(route('dashboard', [
            'q' => 'TEST-DASH-001',
            'status' => 'belum',
        ]));

        $response->assertOk()
            ->assertSee('Mahasiswa Dicari')
            ->assertDontSee('Mahasiswa Lain')
            ->assertSee('Belum tersedia')
            ->assertSee('Belum diprediksi')
            ->assertSee('data-update-url', false)
            ->assertSee('name="n_estimators"', false)
            ->assertSee('Tambah data latih')
            ->assertSee('Mahasiswa per angkatan')
            ->assertSee('Angkatan 2024: 1 mahasiswa', false)
            ->assertSee('Hasil kelulusan data latih alumni')
            ->assertDontSee('0.0%');

        $emptyResponse = $this->actingAs($admin)->get(route('dashboard', ['q' => 'NIM-TIDAK-DITEMUKAN']));
        $emptyResponse->assertOk()
            ->assertSee('Data tidak ditemukan')
            ->assertSee('Coba ubah kata kunci atau filter yang dipilih.');

        $this->actingAs($admin)->put(route('mahasiswa.update', $mahasiswa), [
            'nama' => 'Mahasiswa Diperbarui',
            'angkatan' => 2024,
            'dosen_wali_id' => null,
            'ipk' => 3.40,
            'sks_diambil' => 100,
            'sks_lulus' => 95,
            'jumlah_e' => 0,
            'jumlah_d_cd' => 1,
            'jumlah_c' => 2,
            'rata_rata_inti' => 3.30,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('mahasiswa_target', [
            'id' => $mahasiswa->id,
            'nama' => 'Mahasiswa Diperbarui',
        ]);
    }

    public function test_dashboard_shows_follow_up_alert_for_low_prediction_probability(): void
    {
        $admin = User::create([
            'name' => 'Admin Risk Test',
            'email' => 'dashboard-risk-' . uniqid() . '@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);
        $mahasiswa = MahasiswaTarget::create([
            'nim' => 'TEST-RISK-001',
            'nama' => 'Mahasiswa Perlu Tindak Lanjut',
            'angkatan' => 2024,
            'ipk' => 2.40,
            'sks_diambil' => 100,
            'sks_lulus' => 70,
            'jumlah_e' => 2,
            'jumlah_d_cd' => 3,
            'jumlah_c' => 4,
            'rata_rata_inti' => 2.50,
        ]);

        Http::fake([
            '*predict' => Http::response([
                'predictions' => [[
                    'id' => $mahasiswa->id,
                    'rasio_sks_lulus' => 0.7,
                    'peluang_lulus' => 68.4,
                    'status_prediksi' => 'Berisiko Terlambat / DO',
                ]],
                'metadata' => [],
            ]),
        ]);

        $this->actingAs($admin)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Perlu tindak lanjut')
            ->assertSee('Mahasiswa Perlu Tindak Lanjut')
            ->assertSee('68.4%')
            ->assertSee('di bawah 85%');
    }
}
