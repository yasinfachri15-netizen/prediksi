<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaLatih;
use App\Models\MahasiswaTarget;
use App\Models\ModelTrainingRun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private const RISK_THRESHOLD = 85.0;

    private function mlUrl(): string
    {
        return rtrim((string) env('ML_SERVICE_URL', 'http://127.0.0.1:8001'), '/');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $angkatanFilter = $request->query('angkatan');
        $hanyaBimbingan = $request->boolean('hanya_bimbingan');
        $searchFilter = trim((string) $request->query('q', ''));
        $statusFilter = $request->query('status', 'all');
        $sortFilter = $request->query('urutkan', 'nim');

        if (! in_array($statusFilter, ['all', 'lulus', 'pantauan', 'belum'], true)) {
            $statusFilter = 'all';
        }
        if (! in_array($sortFilter, ['nim', 'nama', 'angkatan', 'ipk', 'peluang'], true)) {
            $sortFilter = 'nim';
        }

        $query = MahasiswaTarget::with('dosenWali');
        if ($angkatanFilter) {
            $query->where('angkatan', (int) $angkatanFilter);
        }
        if ($hanyaBimbingan && $user->role === 'dosen') {
            $query->where('dosen_wali_id', $user->id);
        }
        if ($searchFilter !== '') {
            $query->where(function ($searchQuery) use ($searchFilter) {
                $searchQuery->where('nim', 'like', '%' . $searchFilter . '%')
                    ->orWhere('nama', 'like', '%' . $searchFilter . '%');
            });
        }

        $mahasiswaList = $query->get();
        $daftarAngkatan = MahasiswaTarget::select('angkatan')->distinct()->orderBy('angkatan')->pluck('angkatan');
        $daftarDosen = User::where('role', 'dosen')->orderBy('name')->get();

        $prediksiById = [];
        $metaModel = null;
        $mlError = null;

        try {
            $payload = $mahasiswaList->map(fn ($m) => [
                'id' => $m->id,
                'ipk' => (float) $m->ipk,
                'sks_diambil' => (int) $m->sks_diambil,
                'sks_lulus' => (int) $m->sks_lulus,
                'jumlah_e' => (int) $m->jumlah_e,
                'jumlah_d_cd' => (int) $m->jumlah_d_cd,
                'jumlah_c' => (int) $m->jumlah_c,
                'rata_rata_inti' => (float) $m->rata_rata_inti,
            ])->values()->all();

            $res = Http::timeout(10)->post($this->mlUrl() . '/predict', [
                'items' => $payload,
            ]);

            if ($res->successful()) {
                $body = $res->json();
                $metaModel = $body['metadata'] ?? null;
                foreach (($body['predictions'] ?? []) as $p) {
                    $prediksiById[$p['id']] = $p;
                }
            } else {
                $mlError = $res->json('detail') ?? 'Gagal mengambil prediksi dari ML service.';
            }
        } catch (\Throwable $e) {
            $mlError = 'ML service Python belum aktif atau belum ada model tersimpan.';
        }

        $barisGabungan = $mahasiswaList->map(function ($m) use ($prediksiById) {
            $pred = $prediksiById[$m->id] ?? [
                'rasio_sks_lulus' => $m->rasio_sks_lulus,
                'peluang_lulus' => null,
                'status_prediksi' => 'Belum Diprediksi',
            ];

            return [
                'model' => $m,
                'rasio_sks_lulus' => $pred['rasio_sks_lulus'],
                'peluang_lulus' => $pred['peluang_lulus'],
                'status_prediksi' => $pred['status_prediksi'],
            ];
        });

        $mahasiswaBerisiko = $barisGabungan
            ->filter(fn ($b) => $b['peluang_lulus'] !== null && $b['peluang_lulus'] < self::RISK_THRESHOLD)
            ->sortBy(fn ($b) => $b['peluang_lulus'])
            ->values();
        $totalBerisiko = $mahasiswaBerisiko->count();
        $mahasiswaBerisiko = $mahasiswaBerisiko->take(5);

        if ($statusFilter === 'lulus') {
            $barisGabungan = $barisGabungan->where('status_prediksi', 'Berpotensi Lulus Tepat Waktu');
        } elseif ($statusFilter === 'pantauan') {
            $barisGabungan = $barisGabungan->filter(fn ($b) => $b['peluang_lulus'] !== null && $b['peluang_lulus'] < self::RISK_THRESHOLD);
        } elseif ($statusFilter === 'belum') {
            $barisGabungan = $barisGabungan->where('status_prediksi', 'Belum Diprediksi');
        }

        $barisGabungan = match ($sortFilter) {
            'nama' => $barisGabungan->sortBy(fn ($b) => mb_strtolower($b['model']->nama))->values(),
            'angkatan' => $barisGabungan->sortBy(fn ($b) => (int) $b['model']->angkatan)->values(),
            'ipk' => $barisGabungan->sortByDesc(fn ($b) => (float) $b['model']->ipk)->values(),
            'peluang' => $barisGabungan->sortByDesc(fn ($b) => $b['peluang_lulus'] ?? -1)->values(),
            default => $barisGabungan->sortBy(fn ($b) => $b['model']->nim)->values(),
        };

        $distribusiAngkatan = $barisGabungan
            ->groupBy(fn ($b) => (int) $b['model']->angkatan)
            ->map(fn ($items, $angkatan) => [
                'angkatan' => (int) $angkatan,
                'jumlah' => $items->count(),
            ])
            ->sortBy('angkatan')
            ->values();
        $maxMahasiswaAngkatan = max(1, (int) $distribusiAngkatan->max('jumlah'));
        $totalMhs = $barisGabungan->count();
        $lulusTepat = $barisGabungan->where('status_prediksi', 'Berpotensi Lulus Tepat Waktu')->count();
        $perluPantauan = $barisGabungan->filter(fn ($b) => $b['peluang_lulus'] !== null && $b['peluang_lulus'] < self::RISK_THRESHOLD)->count();
        $belumDiprediksi = $barisGabungan->where('status_prediksi', 'Belum Diprediksi')->count();
        $perluDitinjau = $barisGabungan->filter(fn ($b) => $b['status_prediksi'] !== 'Berpotensi Lulus Tepat Waktu' && $b['status_prediksi'] !== 'Belum Diprediksi')->count();
        $validProb = $barisGabungan->pluck('peluang_lulus')->filter(fn ($v) => $v !== null);
        $rataPeluang = $validProb->count() > 0 ? round($validProb->avg(), 1) : null;

        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $barisGabungan = new LengthAwarePaginator(
            $barisGabungan->forPage($currentPage, $perPage)->values(),
            $totalMhs,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query(), 'fragment' => 'mahasiswa']
        );

        $dataLatih = MahasiswaLatih::orderBy('nim')->get();
        $jumlahDataLatihLulus = $dataLatih->filter(fn ($d) => (int) $d->status_kelulusan === 1)->count();
        $jumlahDataLatihBelumLulus = $dataLatih->count() - $jumlahDataLatihLulus;
        $modelTrainingRuns = $user->role === 'admin'
            ? ModelTrainingRun::latest()->limit(5)->get()
            : collect();
        $riskThreshold = self::RISK_THRESHOLD;
        $diperbaruiPada = now();

        return view('dashboard', compact(
            'user',
            'barisGabungan',
            'distribusiAngkatan',
            'maxMahasiswaAngkatan',
            'daftarAngkatan',
            'daftarDosen',
            'angkatanFilter',
            'hanyaBimbingan',
            'searchFilter',
            'statusFilter',
            'sortFilter',
            'totalMhs',
            'lulusTepat',
            'perluPantauan',
            'totalBerisiko',
            'mahasiswaBerisiko',
            'riskThreshold',
            'belumDiprediksi',
            'perluDitinjau',
            'rataPeluang',
            'metaModel',
            'mlError',
            'dataLatih',
            'jumlahDataLatihLulus',
            'jumlahDataLatihBelumLulus',
            'modelTrainingRuns',
            'diperbaruiPada'
        ));
    }

    public function storeMahasiswa(Request $request)
    {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:30', 'unique:mahasiswa_target,nim'],
            'nama' => ['required', 'string', 'max:120'],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:2100'],
            'dosen_wali_id' => ['nullable', 'exists:users,id'],
            'ipk' => ['required', 'numeric', 'min:0', 'max:4'],
            'sks_diambil' => ['required', 'integer', 'min:1', 'max:200'],
            'sks_lulus' => ['required', 'integer', 'min:0', 'max:200'],
            'jumlah_e' => ['required', 'integer', 'min:0', 'max:50'],
            'jumlah_d_cd' => ['required', 'integer', 'min:0', 'max:50'],
            'jumlah_c' => ['required', 'integer', 'min:0', 'max:50'],
            'rata_rata_inti' => ['required', 'numeric', 'min:0', 'max:4'],
        ]);

        if ($request->user()->role === 'dosen' && empty($validated['dosen_wali_id'])) {
            $validated['dosen_wali_id'] = $request->user()->id;
        }

        MahasiswaTarget::create($validated);

        return redirect()->route('dashboard')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function updateMahasiswa(Request $request, MahasiswaTarget $mahasiswa)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:2100'],
            'dosen_wali_id' => ['nullable', 'exists:users,id'],
            'ipk' => ['required', 'numeric', 'min:0', 'max:4'],
            'sks_diambil' => ['required', 'integer', 'min:1', 'max:200'],
            'sks_lulus' => ['required', 'integer', 'min:0', 'max:200'],
            'jumlah_e' => ['required', 'integer', 'min:0', 'max:50'],
            'jumlah_d_cd' => ['required', 'integer', 'min:0', 'max:50'],
            'jumlah_c' => ['required', 'integer', 'min:0', 'max:50'],
            'rata_rata_inti' => ['required', 'numeric', 'min:0', 'max:4'],
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('dashboard')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroyMahasiswa(MahasiswaTarget $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()->route('dashboard')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    public function simulasi(Request $request)
    {
        $validated = $request->validate([
            'ipk' => ['required', 'numeric', 'min:0', 'max:4'],
            'sks_diambil' => ['required', 'integer', 'min:1', 'max:200'],
            'sks_lulus' => ['required', 'integer', 'min:0', 'max:200'],
            'jumlah_e' => ['required', 'integer', 'min:0', 'max:50'],
            'jumlah_d_cd' => ['required', 'integer', 'min:0', 'max:50'],
            'jumlah_c' => ['required', 'integer', 'min:0', 'max:50'],
            'rata_rata_inti' => ['required', 'numeric', 'min:0', 'max:4'],
        ]);

        try {
            $res = Http::timeout(10)->post($this->mlUrl() . '/predict', [
                'items' => [$validated],
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors(['simulasi' => 'ML service Python belum aktif.'])->withInput();
        }

        if (! $res->successful()) {
            return back()->withErrors(['simulasi' => $res->json('detail') ?? 'Gagal menjalankan simulasi.'])->withInput();
        }

        $pred = $res->json('predictions.0');

        return back()->with('hasil_simulasi', $pred)->withInput();
    }
}