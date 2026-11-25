<?php

namespace Tests\Feature;

use App\Models\MahasiswaLatih;
use App\Models\ModelTrainingRun;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ModelTrainingHistoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_successful_training_is_saved_and_shown_with_evaluation_metrics(): void
    {
        $admin = User::create([
            'name' => 'Admin Model Test',
            'email' => 'model-history-' . uniqid() . '@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);
        MahasiswaLatih::create([
            'nim' => 'TEST-TRAIN-001',
            'nama' => 'Alumni Lulus',
            'angkatan' => 2022,
            'ipk' => 3.40,
            'sks_diambil' => 144,
            'sks_lulus' => 144,
            'jumlah_e' => 0,
            'jumlah_d_cd' => 0,
            'jumlah_c' => 2,
            'rata_rata_inti' => 3.50,
            'status_kelulusan' => 1,
        ]);

        Http::fake([
            '*/train' => Http::response([
                'metadata' => [
                    'evaluasi' => [
                        'method' => 'Stratified 2-fold cross-validation',
                        'folds' => 2,
                        'samples' => 4,
                        'accuracy' => 75.0,
                        'precision' => 66.67,
                        'recall' => 100.0,
                        'f1_score' => 80.0,
                        'confusion_matrix' => [
                            'labels' => ['Belum lulus', 'Lulus'],
                            'matrix' => [[1, 1], [0, 2]],
                        ],
                        'warning' => 'Data sangat terbatas; metrik evaluasi ini hanya indikatif.',
                    ],
                ],
            ]),
            '*/predict' => Http::response(['predictions' => [], 'metadata' => null]),
        ]);

        $this->actingAs($admin)->post(route('admin.train'), [
            'n_estimators' => 100,
            'max_depth' => 5,
            'random_state' => 42,
        ])->assertRedirect(route('dashboard'))
            ->assertSessionHas('success', 'Model berhasil dilatih. Akurasi evaluasi: 75.00% (Stratified 2-fold cross-validation, 4 data).');

        $run = ModelTrainingRun::query()->latest('id')->firstOrFail();
        $this->assertSame(MahasiswaLatih::count(), $run->training_samples);
        $this->assertSame(4, $run->evaluation_samples);
        $this->assertSame(75.0, (float) $run->evaluation_metrics['accuracy']);
        $this->assertSame(100, $run->parameters['n_estimators']);

        $this->actingAs($admin)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Riwayat & evaluasi', false)
            ->assertSee('75.00%')
            ->assertSee('Rincian evaluasi')
            ->assertSee('Confusion matrix');
    }
}
