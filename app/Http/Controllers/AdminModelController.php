<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaLatih;
use App\Models\ModelTrainingRun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminModelController extends Controller
{
    private function mlUrl(): string
    {
        return rtrim((string) env('ML_SERVICE_URL', 'http://127.0.0.1:8001'), '/');
    }

    public function storeLatih(Request $request)
    {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:30', 'unique:mahasiswa_latih,nim'],
            'nama' => ['required', 'string', 'max:120'],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:2100'],
            'ipk' => ['required', 'numeric', 'min:0', 'max:4'],
            'sks_diambil' => ['required', 'integer', 'min:1', 'max:200'],
            'sks_lulus' => ['required', 'integer', 'min:0', 'max:200'],
            'jumlah_e' => ['required', 'integer', 'min:0', 'max:50'],
            'jumlah_d_cd' => ['required', 'integer', 'min:0', 'max:50'],
            'jumlah_c' => ['required', 'integer', 'min:0', 'max:50'],
            'rata_rata_inti' => ['required', 'numeric', 'min:0', 'max:4'],
            'status_kelulusan' => ['required', 'in:0,1'],
        ]);

        MahasiswaLatih::create($validated);

        return redirect()->route('dashboard')->with('success', 'Data latih berhasil ditambahkan. Silakan latih ulang model.');
    }

    public function destroyLatih(MahasiswaLatih $latih)
    {
        $latih->delete();

        return redirect()->route('dashboard')->with('success', 'Data latih berhasil dihapus.');
    }

    public function train(Request $request)
    {
        $validated = $request->validate([
            'n_estimators' => ['required', 'integer', 'min:10', 'max:500'],
            'max_depth' => ['nullable', 'integer', 'min:1', 'max:50'],
            'random_state' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);

        $dataLatih = MahasiswaLatih::all()->map(fn ($d) => [
            'ipk' => (float) $d->ipk,
            'sks_diambil' => (int) $d->sks_diambil,
            'sks_lulus' => (int) $d->sks_lulus,
            'jumlah_e' => (int) $d->jumlah_e,
            'jumlah_d_cd' => (int) $d->jumlah_d_cd,
            'jumlah_c' => (int) $d->jumlah_c,
            'rata_rata_inti' => (float) $d->rata_rata_inti,
            'status_kelulusan' => (int) $d->status_kelulusan,
        ])->values()->all();

        try {
            $res = Http::timeout(30)->post($this->mlUrl() . '/train', [
                'data_latih' => $dataLatih,
                'n_estimators' => (int) $validated['n_estimators'],
                'max_depth' => $validated['max_depth'] ? (int) $validated['max_depth'] : null,
                'random_state' => (int) $validated['random_state'],
                'dilatih_oleh' => $request->user()->email,
            ]);
        } catch (\Throwable $e) {
            return redirect()->route('dashboard')->withErrors([
                'train' => 'Tidak dapat terhubung ke ML service Python. Pastikan uvicorn sudah berjalan.',
            ]);
        }

        if (! $res->successful()) {
            return redirect()->route('dashboard')->withErrors([
                'train' => $res->json('detail') ?? 'Gagal melatih model pada service Python.',
            ]);
        }

        $meta = $res->json('metadata');
        if (! is_array($meta)) {
            return redirect()->route('dashboard')->withErrors([
                'train' => 'Layanan ML tidak mengembalikan metadata pelatihan yang valid.',
            ]);
        }

        $evaluation = $meta['evaluasi'] ?? null;
        if ($evaluation !== null && ! is_array($evaluation)) {
            return redirect()->route('dashboard')->withErrors([
                'train' => 'Layanan ML mengembalikan format evaluasi yang tidak valid.',
            ]);
        }

        $parameters = [
            'n_estimators' => (int) $validated['n_estimators'],
            'max_depth' => $validated['max_depth'] ? (int) $validated['max_depth'] : null,
            'random_state' => (int) $validated['random_state'],
        ];

        ModelTrainingRun::create([
            'trained_by' => $request->user()->email,
            'training_samples' => count($dataLatih),
            'evaluation_samples' => isset($evaluation['samples']) ? (int) $evaluation['samples'] : null,
            'evaluation_method' => $evaluation['method'] ?? null,
            'evaluation_metrics' => $evaluation,
            'parameters' => $parameters,
        ]);

        if (isset($evaluation['accuracy'])) {
            $success = sprintf(
                'Model berhasil dilatih. Akurasi evaluasi: %.2f%% (%s, %d data).',
                $evaluation['accuracy'],
                $evaluation['method'] ?? 'metode tidak tersedia',
                $evaluation['samples'] ?? 0
            );
        } else {
            $success = 'Model berhasil dilatih, tetapi metrik evaluasi belum tersedia. '
                . ($evaluation['warning'] ?? 'Jumlah data belum memadai.');
        }

        return redirect()->route('dashboard')->with('success', $success);
    }
}