<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f4f8ff">
    <title>Dashboard Akademik — Prediksi Kelulusan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #102b4e;
            --blue: #1473e6;
            --blue-deep: #0758bd;
            --sky: #f3f8ff;
            --sky-strong: #e7f2ff;
            --border: #e4edf7;
            --amber: #ffc83d;
            --ink: #263a53;
            --muted: #6d7f95;
            --green: #15966a;
        }

        html { scroll-behavior: smooth; scroll-padding-top: 88px; }
        body {
            background: #f8fbff;
            color: var(--ink);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .92rem;
        }
        .site-nav {
            position: sticky;
            top: 0;
            z-index: 1020;
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
        }
        .nav-inner { min-height: 76px; }
        .brand { display: inline-flex; align-items: center; gap: .7rem; text-decoration: none; }
        .brand-mark {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: linear-gradient(140deg, var(--navy), var(--blue));
            color: #fff;
            font-size: 1.2rem;
            box-shadow: 0 7px 16px rgba(20,115,230,.2);
        }
        .brand-name { color: var(--navy); font-size: .96rem; font-weight: 800; line-height: 1.15; }
        .brand-caption { color: var(--muted); font-size: .67rem; font-weight: 500; }
        .nav-menu { display: flex; align-items: center; gap: .2rem; }
        .nav-menu a {
            color: #53677f;
            font-size: .8rem;
            font-weight: 700;
            padding: .6rem .72rem;
            border-radius: 9px;
            text-decoration: none;
            transition: background .2s, color .2s;
        }
        .nav-menu a:hover { color: var(--blue); background: var(--sky); }
        .mobile-nav-toggle { display: none; }
        .mobile-nav-menu { border-top: 1px solid var(--border); }
        .mobile-nav-menu a { display: block; padding: .7rem .25rem; color: #53677f; font-size: .84rem; font-weight: 700; text-decoration: none; }
        .mobile-nav-menu a:hover { color: var(--blue); }
        .role-chip { background: #eef5ff; color: var(--blue-deep); border-radius: 999px; padding: .42rem .7rem; font-size: .74rem; font-weight: 700; }
        .btn-primary { background: var(--blue); border-color: var(--blue); }
        .btn-primary:hover { background: var(--blue-deep); border-color: var(--blue-deep); }
        .btn-sun { background: var(--amber); border: 0; color: var(--navy); font-weight: 800; }
        .btn-sun:hover { background: #f2b91f; color: var(--navy); }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 3.2rem 0 3rem;
            background:
                radial-gradient(ellipse at 82% 40%, rgba(52,151,255,.23), transparent 38%),
                linear-gradient(115deg, #fff 8%, #eff7ff 58%, #dceeff 100%);
            border-bottom: 1px solid #dfeeff;
        }
        .hero::after {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            right: -120px;
            top: -175px;
            border: 1px solid rgba(20,115,230,.12);
            border-radius: 50%;
            box-shadow: 0 0 0 35px rgba(20,115,230,.035), 0 0 0 75px rgba(20,115,230,.025);
            pointer-events: none;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: var(--blue-deep);
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .13em;
            text-transform: uppercase;
        }
        .eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--amber); }
        .hero-title {
            max-width: 670px;
            color: var(--navy);
            font-size: clamp(2rem, 4vw, 3.25rem);
            font-weight: 800;
            letter-spacing: -.055em;
            line-height: 1.12;
        }
        .hero-title span { color: var(--blue); }
        .hero-description { max-width: 590px; color: #5c7088; font-size: .97rem; line-height: 1.8; }
        .hero-art {
            position: relative;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-orbit {
            width: 225px;
            height: 225px;
            position: absolute;
            border: 1px solid rgba(20,115,230,.16);
            border-radius: 50%;
            box-shadow: 0 0 0 20px rgba(255,255,255,.28), 0 0 0 44px rgba(255,255,255,.22);
        }
        .hero-cap {
            position: relative;
            z-index: 1;
            width: 162px;
            height: 162px;
            display: grid;
            place-items: center;
            border: 10px solid rgba(255,255,255,.76);
            border-radius: 50%;
            background: linear-gradient(145deg, #fff, #dcecff);
            color: var(--blue);
            font-size: 4.7rem;
            box-shadow: 0 22px 50px rgba(16,65,123,.15);
        }
        .hero-float {
            position: absolute;
            z-index: 2;
            padding: .8rem 1rem;
            border: 1px solid rgba(228,237,247,.9);
            border-radius: 14px;
            background: rgba(255,255,255,.96);
            box-shadow: 0 12px 30px rgba(16,43,78,.1);
        }
        .hero-float-top { top: 20px; right: 0; }
        .hero-float-bottom { bottom: 17px; left: 0; }
        .float-label { color: var(--muted); font-size: .67rem; }
        .float-value { color: var(--navy); font-size: .82rem; font-weight: 800; }
        .model-dot { display: inline-block; width: 7px; height: 7px; margin-right: .25rem; border-radius: 50%; background: var(--green); }

        .feature-strip { background: #fff; border-bottom: 1px solid var(--border); }
        .feature-item { display: flex; align-items: center; gap: .8rem; height: 100%; padding: 1.15rem .8rem; }
        .feature-icon {
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            font-size: 1.1rem;
        }
        .feature-title { color: var(--navy); font-size: .77rem; font-weight: 800; }
        .feature-caption { color: var(--muted); font-size: .68rem; line-height: 1.45; }

        .section-kicker { color: var(--blue); font-size: .67rem; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; }
        .section-title { color: var(--navy); font-size: 1.35rem; font-weight: 800; letter-spacing: -.035em; }
        .section-description { color: var(--muted); font-size: .83rem; }
        .summary-section { padding-top: 2.5rem; }
        .metric-card {
            height: 100%;
            padding: 1.15rem;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 7px 22px rgba(16,43,78,.035);
            transition: transform .2s, box-shadow .2s;
        }
        .metric-card:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(16,43,78,.08); }
        .metric-icon { width: 43px; height: 43px; display: grid; place-items: center; border-radius: 13px; font-size: 1.12rem; }
        .metric-value { margin-top: 1rem; color: var(--navy); font-size: 1.7rem; font-weight: 800; letter-spacing: -.04em; }
        .metric-label { color: var(--muted); font-size: .74rem; font-weight: 600; }
        .metric-note { color: #94a3b8; font-size: .66rem; }
        .distribution-card { padding: 1.15rem; border: 1px solid var(--border); border-radius: 16px; background: #fff; }
        .distribution-track { display: flex; height: 10px; overflow: hidden; border-radius: 999px; background: #edf2f8; }
        .distribution-segment { min-width: 0; transition: width .25s ease; }
        .distribution-legend { color: var(--muted); font-size: .72rem; }
        .distribution-count { color: var(--navy); font-size: .84rem; font-weight: 800; }
        .cohort-card { padding: 1.15rem; border: 1px solid var(--border); border-radius: 16px; background: #fff; }
        .cohort-chart { display: grid; gap: .9rem; margin-top: 1rem; }
        .cohort-row { display: grid; grid-template-columns: 90px minmax(0, 1fr) 32px; align-items: center; gap: .65rem; }
        .cohort-label { color: var(--ink); font-size: .72rem; font-weight: 700; }
        .cohort-count { color: var(--navy); font-size: .74rem; font-weight: 800; text-align: right; }
        .cohort-progress { display: block; width: 100%; height: 10px; overflow: hidden; border: 0; border-radius: 999px; accent-color: var(--blue); background: #edf2f8; }
        .cohort-progress::-webkit-progress-bar { border-radius: 999px; background: #edf2f8; }
        .cohort-progress::-webkit-progress-value { border-radius: 999px; background: linear-gradient(90deg, #1473e6, #54a2ff); }
        .cohort-progress::-moz-progress-bar { border-radius: 999px; background: linear-gradient(90deg, #1473e6, #54a2ff); }
        .cohort-progress-success { accent-color: var(--green); }
        .cohort-progress-success::-webkit-progress-value, .cohort-progress-success::-moz-progress-bar { background: linear-gradient(90deg, #15966a, #50c99b); }
        .cohort-progress-warning { accent-color: #e2a400; }
        .cohort-progress-warning::-webkit-progress-value, .cohort-progress-warning::-moz-progress-bar { background: linear-gradient(90deg, #e2a400, #ffd25c); }
        .cohort-empty { min-height: 76px; display: grid; place-content: center; text-align: center; }
        .chart-empty { min-height: 76px; display: flex; align-items: center; gap: .55rem; color: var(--muted); font-size: .75rem; }

        .content-section { padding-top: 2.3rem; padding-bottom: 3.2rem; }
        .panel {
            border: 1px solid var(--border);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 9px 28px rgba(16,43,78,.045);
        }
        .content-section > .row { align-items: flex-start; }
        .panel-heading { padding: 1.2rem 1.25rem; border-bottom: 1px solid #edf2f8; }
        .panel-body { padding: 1.2rem 1.25rem; }
        .panel-title { color: var(--navy); font-size: .96rem; font-weight: 800; }
        .panel-subtitle { color: var(--muted); font-size: .73rem; }
        .form-label { color: #51667e; font-size: .74rem; font-weight: 700; }
        .form-control, .form-select { border-color: #dce6f1; border-radius: 9px; font-size: .81rem; }
        .form-control:focus, .form-select:focus { border-color: #8dbdff; box-shadow: 0 0 0 .2rem rgba(20,115,230,.1); }
        .table { --bs-table-hover-bg: #f7faff; }
        .table thead th { padding: .72rem .62rem; background: #f7faff; color: #647990; font-size: .65rem; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; white-space: nowrap; }
        .table tbody td { padding: .75rem .62rem; color: #475b73; font-size: .75rem; vertical-align: middle; }
        .table thead th:first-child { border-top-left-radius: 9px; }
        .table thead th:last-child { border-top-right-radius: 9px; }
        .student-name { color: var(--navy); font-weight: 700; }
        .status-pill { display: inline-block; border-radius: 999px; padding: .38rem .62rem; font-size: .65rem; font-weight: 800; white-space: nowrap; }
        .status-lulus { background: #e2f7ee; color: #14744f; }
        .status-pantauan { background: #fff5d6; color: #8c5c00; }
        .status-belum { background: #eff3f8; color: #5a6c80; }
        .model-panel { background: linear-gradient(145deg, #fff, #f8fbff); }
        .model-subpanel { padding: 1rem; border: 1px solid var(--border); border-radius: 14px; background: rgba(255,255,255,.82); }
        .model-subtitle { color: var(--navy); font-size: .84rem; font-weight: 800; }
        .model-symbol { width: 46px; height: 46px; display: grid; place-items: center; border-radius: 14px; background: #eaf3ff; color: var(--blue); font-size: 1.25rem; }
        .training-table { max-height: 220px; overflow: auto; }
        .risk-alert { padding: 1.1rem; border: 1px solid #f3d889; border-radius: 16px; background: #fffaf0; }
        .risk-symbol { width: 40px; height: 40px; flex: 0 0 40px; display: grid; place-items: center; border-radius: 12px; background: #fff0c2; color: #8c5c00; font-size: 1.1rem; }
        .risk-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: .55rem; margin-top: .9rem; }
        .risk-item { display: flex; justify-content: space-between; align-items: center; gap: .75rem; min-width: 0; padding: .65rem .75rem; border: 1px solid #f5e7bf; border-radius: 11px; background: rgba(255,255,255,.82); }
        .history-run { padding: .8rem; border: 1px solid var(--border); border-radius: 12px; background: #fff; }
        .history-run + .history-run { margin-top: .65rem; }
        .history-metrics { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .45rem; margin-top: .65rem; }
        .history-metric { padding: .45rem .55rem; border-radius: 9px; background: #f5f8fc; }
        .history-metric-label { display: block; color: var(--muted); font-size: .64rem; }
        .history-metric-value { color: var(--navy); font-size: .78rem; font-weight: 800; }
        .site-footer { margin-top: 2rem; border-top: 4px solid var(--blue); background: linear-gradient(115deg, #0d2542, #163d68); color: rgba(255,255,255,.76); }
        .footer-inner { display: grid; grid-template-columns: minmax(220px, 1fr) minmax(260px, 1.4fr) auto; align-items: center; gap: 1.5rem; padding-block: 1.55rem; }
        .footer-brand { display: flex; align-items: center; gap: .75rem; }
        .footer-mark { width: 40px; height: 40px; display: grid; place-items: center; border: 1px solid rgba(255,255,255,.18); border-radius: 12px; background: rgba(255,255,255,.1); color: #fff; font-size: 1.1rem; }
        .footer-title { color: #fff; font-size: .85rem; font-weight: 800; }
        .footer-copy, .footer-note { color: rgba(255,255,255,.68); font-size: .7rem; }
        .footer-note { max-width: 430px; margin: 0; line-height: 1.65; }
        .footer-link { display: inline-flex; align-items: center; gap: .4rem; padding: .55rem .8rem; border: 1px solid rgba(255,255,255,.22); border-radius: 999px; color: #fff; font-size: .72rem; font-weight: 700; text-decoration: none; transition: background .2s, border-color .2s; }
        .footer-link:hover { border-color: rgba(255,255,255,.5); background: rgba(255,255,255,.1); color: #fff; }
        .modal-content { border: 0; border-radius: 17px; box-shadow: 0 24px 70px rgba(16,43,78,.2); }
        .modal-header, .modal-footer { border-color: #edf2f8; }
        .modal-dialog-scrollable .modal-content > form { display: flex; flex: 1 1 auto; flex-direction: column; min-height: 0; overflow: hidden; }
        .modal-dialog-scrollable .modal-body { min-height: 0; overflow-y: auto; }

        @media (max-width: 991.98px) {
            .nav-menu { display: none; }
            .mobile-nav-toggle { display: inline-flex; }
            .hero { padding: 2.6rem 0 2.2rem; }
            .hero-art { min-height: 220px; margin-top: .5rem; }
            .hero-float-top { right: 8%; }
            .hero-float-bottom { left: 8%; }
            .footer-inner { grid-template-columns: minmax(0, 1fr) auto; }
            .footer-note { grid-column: 1 / -1; grid-row: 2; }
        }
        @media (max-width: 575.98px) {
            .nav-inner { min-height: 66px; }
            .brand-caption, .role-chip { display: none; }
            .hero-title { font-size: 2.15rem; }
            .hero-art { min-height: 195px; }
            .hero-cap { width: 138px; height: 138px; font-size: 4rem; }
            .hero-orbit { width: 190px; height: 190px; }
            .hero-float { padding: .65rem .75rem; }
            .hero-float-top { right: 0; }
            .hero-float-bottom { left: 0; }
            .feature-strip .row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .feature-strip .row > .col { width: auto; }
            .feature-item { padding: .8rem .25rem; }
            .feature-caption { display: none; }
            .feature-icon { flex-basis: 36px; width: 36px; height: 36px; }
            .feature-title { font-size: .68rem; }
            .panel-heading, .panel-body { padding-right: .9rem; padding-left: .9rem; }
            .cohort-row { grid-template-columns: 76px minmax(0, 1fr) 26px; gap: .45rem; }
            .footer-inner { grid-template-columns: 1fr; justify-items: center; gap: .8rem; text-align: center; }
            .footer-note { grid-column: auto; grid-row: auto; }
            #mahasiswa .table-responsive { overflow: visible; }
            #mahasiswa table { display: block; }
            #mahasiswa table thead { display: none; }
            #mahasiswa table tbody { display: grid; gap: .7rem; }
            #mahasiswa table tbody tr { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); border: 1px solid var(--border); border-radius: 12px; background: #fff; }
            #mahasiswa table tbody td { display: flex; flex-direction: column; min-width: 0; padding: .65rem; border: 0; overflow-wrap: anywhere; }
            #mahasiswa table tbody td[data-label]::before { content: attr(data-label); margin-bottom: .28rem; color: var(--muted); font-size: .59rem; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; }
            #mahasiswa table tbody td[data-label="Aksi"] { grid-column: 1 / -1; flex-direction: row; align-items: center; gap: .6rem; border-top: 1px solid #edf2f8; }
            #mahasiswa table tbody td[data-label="Aksi"] form { margin: 0; }
            #mahasiswa table tbody td[colspan] { grid-column: 1 / -1; align-items: center; text-align: center; }
        }
    </style>
</head>
<body>
<nav class="site-nav" id="top">
    <div class="container">
        <div class="nav-inner d-flex align-items-center justify-content-between gap-3">
            <a class="brand" href="{{ route('dashboard') }}" aria-label="Dashboard Prediksi Kelulusan">
                <span class="brand-mark"><i class="bi bi-mortarboard-fill"></i></span>
                <span>
                    <span class="brand-name d-block">Pusat Prediksi Kelulusan</span>
                    <span class="brand-caption d-block">Program Studi Sistem Informasi</span>
                </span>
            </a>
            <div class="nav-menu">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="#mahasiswa">Data Mahasiswa</a>
                <a href="#simulasi">Simulasi</a>
                @if ($user->role === 'admin')
                    <a href="#model">Manajemen Model</a>
                @endif
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="role-chip"><i class="bi bi-person-circle me-1"></i>{{ $user->name }} · {{ ucfirst($user->role) }}</span>
                <button class="btn btn-outline-primary btn-sm rounded-pill px-3 mobile-nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavMenu" aria-controls="mobileNavMenu" aria-expanded="false">
                    <i class="bi bi-list me-1"></i>Menu
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" type="submit" aria-label="Keluar">
                        <i class="bi bi-box-arrow-right me-sm-1"></i><span class="d-none d-sm-inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="collapse d-lg-none" id="mobileNavMenu">
            <div class="mobile-nav-menu pb-2">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="#mahasiswa">Data Mahasiswa</a>
                <a href="#simulasi">Simulasi</a>
                @if ($user->role === 'admin')
                    <a href="#model">Manajemen Model</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<header class="hero">
    <div class="container position-relative" style="z-index: 1;">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="eyebrow mb-3"><span class="eyebrow-dot"></span> Pendampingan akademik berbasis data</div>
                <h1 class="hero-title mb-3">Mendampingi mahasiswa menuju <span>kelulusan terbaik.</span></h1>
                <p class="hero-description mb-4">Selamat datang, {{ $user->name }}. Pantau perkembangan akademik, kenali mahasiswa yang memerlukan perhatian, dan gunakan prediksi sebagai dasar pendampingan yang lebih terarah.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-sun rounded-pill px-4 py-2" href="#mahasiswa"><i class="bi bi-arrow-down-right me-2"></i>Lihat data mahasiswa</a>
                    <a class="btn btn-outline-primary rounded-pill px-4 py-2" href="#simulasi"><i class="bi bi-stars me-2"></i>Coba simulasi</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="hero-art" aria-hidden="true">
                    <div class="hero-orbit"></div>
                    <div class="hero-cap"><i class="bi bi-mortarboard-fill"></i></div>
                    <div class="hero-float hero-float-top">
                        <div class="float-label mb-1">Status layanan prediksi</div>
                        <div class="float-value">
                            @if ($mlError || ! $metaModel)
                                <i class="bi bi-exclamation-circle-fill text-warning me-1"></i>Perlu pemeriksaan
                            @else
                                <span class="model-dot"></span>Siap digunakan
                            @endif
                        </div>
                    </div>
                    <div class="hero-float hero-float-bottom">
                        <div class="float-label mb-1">Rata-rata peluang kelulusan</div>
                        <div class="float-value">
                            <i class="bi bi-graph-up-arrow text-primary me-1"></i>
                            {{ $rataPeluang !== null ? number_format($rataPeluang, 1).'%' : 'Belum tersedia' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="feature-strip" aria-label="Fitur utama">
    <div class="container">
        <div class="row row-cols-5 g-0">
            <div class="col"><div class="feature-item"><span class="feature-icon text-primary bg-primary-subtle"><i class="bi bi-mortarboard"></i></span><div><div class="feature-title">Data akademik</div><div class="feature-caption">Catatan mahasiswa terpusat</div></div></div></div>
            <div class="col"><div class="feature-item"><span class="feature-icon text-success bg-success-subtle"><i class="bi bi-graph-up-arrow"></i></span><div><div class="feature-title">Prediksi terukur</div><div class="feature-caption">Gambaran peluang kelulusan</div></div></div></div>
            <div class="col"><div class="feature-item"><span class="feature-icon text-warning bg-warning-subtle"><i class="bi bi-eye"></i></span><div><div class="feature-title">Pantauan dini</div><div class="feature-caption">Dukungan sesuai kebutuhan</div></div></div></div>
            <div class="col"><div class="feature-item"><span class="feature-icon text-info bg-info-subtle"><i class="bi bi-calculator"></i></span><div><div class="feature-title">Simulasi</div><div class="feature-caption">Uji skenario akademik</div></div></div></div>
            <div class="col"><div class="feature-item"><span class="feature-icon text-danger bg-danger-subtle"><i class="bi bi-shield-check"></i></span><div><div class="feature-title">Pendampingan</div><div class="feature-caption">Keputusan tetap oleh dosen</div></div></div></div>
        </div>
    </div>
</section>

<main class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    @if ($mlError)
        <div class="alert alert-warning d-flex align-items-start gap-2 mt-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
            <div><strong>Layanan prediksi belum tersedia.</strong><br><span class="small">{{ $mlError }}</span></div>
        </div>
    @endif

    <section class="summary-section" aria-labelledby="summaryTitle">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
            <div>
                <div class="section-kicker mb-1">Ringkasan akademik</div>
                <h2 class="section-title mb-1" id="summaryTitle">Gambaran mahasiswa</h2>
                <p class="section-description mb-0">Ikhtisar berdasarkan data dan hasil prediksi yang tersedia.</p>
            </div>
            <span class="small text-muted"><i class="bi bi-clock me-1"></i>Diperbarui {{ $diperbaruiPada->format('d/m/Y H:i') }}</span>
        </div>
        <div class="row row-cols-2 row-cols-lg-4 g-3">
            <div class="col">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-start"><span class="metric-icon text-primary bg-primary-subtle"><i class="bi bi-people-fill"></i></span><i class="bi bi-three-dots text-muted"></i></div>
                    <div class="metric-value">{{ $totalMhs }}</div>
                    <div class="metric-label">Mahasiswa terdata</div>
                    <div class="metric-note mt-1">Sesuai filter yang dipilih</div>
                </div>
            </div>
            <div class="col">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-start"><span class="metric-icon text-success bg-success-subtle"><i class="bi bi-check2-circle"></i></span><i class="bi bi-three-dots text-muted"></i></div>
                    <div class="metric-value">{{ $lulusTepat }}</div>
                    <div class="metric-label">Berpotensi lulus tepat waktu</div>
                    <div class="metric-note mt-1">Berdasarkan keluaran model</div>
                </div>
            </div>
            <div class="col">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-start"><span class="metric-icon text-warning bg-warning-subtle"><i class="bi bi-eye-fill"></i></span><i class="bi bi-three-dots text-muted"></i></div>
                    <div class="metric-value">{{ $perluPantauan }}</div>
                    <div class="metric-label">Perlu perhatian lebih lanjut</div>
                    <div class="metric-note mt-1">Peluang prediksi di bawah 85%</div>
                </div>
            </div>
            <div class="col">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-start"><span class="metric-icon text-info bg-info-subtle"><i class="bi bi-bar-chart-line-fill"></i></span><i class="bi bi-three-dots text-muted"></i></div>
                    <div class="metric-value">{{ $rataPeluang !== null ? number_format($rataPeluang, 1).'%' : '—' }}</div>
                    <div class="metric-label">Rata-rata peluang kelulusan</div>
                    <div class="metric-note mt-1">{{ $rataPeluang !== null ? 'Dari prediksi yang berhasil dihitung' : 'Belum ada hasil prediksi' }}</div>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-0">
            <div class="col-lg-7">
                <div class="distribution-card">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                        <div>
                            <h3 class="panel-title mb-1">Distribusi hasil prediksi</h3>
                            <p class="panel-subtitle mb-0">Ringkasan mengikuti hasil filter di bawah ini.</p>
                        </div>
                        <span class="small text-muted">{{ $totalMhs }} mahasiswa</span>
                    </div>
                    @if ($totalMhs > 0)
                        <div class="distribution-track" role="img" aria-label="Distribusi hasil prediksi mahasiswa">
                            <span class="distribution-segment bg-success" data-distribution-width="{{ round($lulusTepat / $totalMhs * 100, 1) }}"></span>
                            <span class="distribution-segment bg-warning" data-distribution-width="{{ round($perluDitinjau / $totalMhs * 100, 1) }}"></span>
                            <span class="distribution-segment bg-secondary" data-distribution-width="{{ round($belumDiprediksi / $totalMhs * 100, 1) }}"></span>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-sm-4 d-flex align-items-center justify-content-between gap-2">
                                <span class="distribution-legend"><i class="bi bi-circle-fill text-success me-1"></i>Berpotensi lulus</span>
                                <span class="distribution-count">{{ $lulusTepat }}</span>
                            </div>
                            <div class="col-sm-4 d-flex align-items-center justify-content-between gap-2">
                                <span class="distribution-legend"><i class="bi bi-circle-fill text-warning me-1"></i>Perlu ditinjau</span>
                                <span class="distribution-count">{{ $perluDitinjau }}</span>
                            </div>
                            <div class="col-sm-4 d-flex align-items-center justify-content-between gap-2">
                                <span class="distribution-legend"><i class="bi bi-circle-fill text-secondary me-1"></i>Belum diprediksi</span>
                                <span class="distribution-count">{{ $belumDiprediksi }}</span>
                            </div>
                        </div>
                    @else
                        <div class="chart-empty"><i class="bi bi-info-circle"></i>Tidak ada mahasiswa yang sesuai filter untuk ditampilkan.</div>
                    @endif
                </div>
            </div>
            <div class="col-lg-5">
                <div class="cohort-card" aria-labelledby="cohortChartTitle">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <div>
                            <h3 class="panel-title mb-1" id="cohortChartTitle">Mahasiswa per angkatan</h3>
                            <p class="panel-subtitle mb-0">Mahasiswa aktif dan data latih alumni ditampilkan terpisah.</p>
                        </div>
                        <span class="model-symbol"><i class="bi bi-bar-chart-line-fill"></i></span>
                    </div>
                    @if ($distribusiAngkatan->isNotEmpty())
                        <div class="cohort-chart">
                            @foreach ($distribusiAngkatan as $angkatanData)
                            <div class="cohort-row">
                                <span class="cohort-label">Angkatan {{ $angkatanData['angkatan'] }}</span>
                                <progress class="cohort-progress" max="{{ $maxMahasiswaAngkatan }}" value="{{ $angkatanData['jumlah'] }}" aria-label="Angkatan {{ $angkatanData['angkatan'] }}: {{ $angkatanData['jumlah'] }} mahasiswa">{{ $angkatanData['jumlah'] }}</progress>
                                <span class="cohort-count">{{ $angkatanData['jumlah'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="cohort-empty">
                            <div>
                                <i class="bi bi-bar-chart-line fs-3 text-primary"></i>
                                <p class="small text-muted mt-2 mb-0">Belum ada mahasiswa aktif untuk digrafikkan.</p>
                                <button class="btn btn-primary btn-sm rounded-pill px-3 mt-3" type="button" data-bs-toggle="modal" data-bs-target="#mahasiswaModal">
                                    <i class="bi bi-plus-lg me-1"></i>Tambah mahasiswa
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <h4 class="small fw-bold text-dark mb-0">Hasil kelulusan data latih alumni</h4>
                            <span class="small text-muted">{{ $dataLatih->count() }} data</span>
                        </div>
                        @if ($dataLatih->isNotEmpty())
                            <div class="cohort-chart">
                                <div class="cohort-row">
                                    <span class="cohort-label">Lulus tepat waktu</span>
                                    <progress class="cohort-progress cohort-progress-success" max="{{ max(1, $dataLatih->count()) }}" value="{{ $jumlahDataLatihLulus }}" aria-label="Alumni lulus tepat waktu: {{ $jumlahDataLatihLulus }} dari {{ $dataLatih->count() }}">{{ $jumlahDataLatihLulus }}</progress>
                                    <span class="cohort-count">{{ $jumlahDataLatihLulus }}</span>
                                </div>
                                <div class="cohort-row">
                                    <span class="cohort-label">Tidak tepat waktu</span>
                                    <progress class="cohort-progress cohort-progress-warning" max="{{ max(1, $dataLatih->count()) }}" value="{{ $jumlahDataLatihBelumLulus }}" aria-label="Alumni tidak lulus tepat waktu: {{ $jumlahDataLatihBelumLulus }} dari {{ $dataLatih->count() }}">{{ $jumlahDataLatihBelumLulus }}</progress>
                                    <span class="cohort-count">{{ $jumlahDataLatihBelumLulus }}</span>
                                </div>
                            </div>
                        @else
                            <p class="small text-muted mt-2 mb-0">Belum ada data latih alumni.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($totalBerisiko > 0)
        <section class="risk-alert mt-4" aria-labelledby="riskAlertTitle">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-start gap-3">
                    <span class="risk-symbol"><i class="bi bi-exclamation-triangle-fill"></i></span>
                    <div>
                        <h2 class="panel-title mb-1" id="riskAlertTitle">Perlu tindak lanjut</h2>
                        <p class="panel-subtitle mb-0">{{ $totalBerisiko }} mahasiswa memiliki peluang kelulusan di bawah {{ number_format($riskThreshold, 0) }}%.</p>
                    </div>
                </div>
                <a class="btn btn-outline-warning btn-sm rounded-pill px-3" href="{{ route('dashboard', ['status' => 'pantauan']) }}#mahasiswa">
                    Lihat daftar mahasiswa <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="risk-list">
                @foreach ($mahasiswaBerisiko as $risiko)
                    @php $mhsRisiko = $risiko['model']; @endphp
                    <div class="risk-item">
                        <div class="min-w-0">
                            <div class="student-name text-truncate">{{ $mhsRisiko->nama }}</div>
                            <div class="small text-muted">NIM {{ $mhsRisiko->nim }} · Angkatan {{ $mhsRisiko->angkatan }}</div>
                        </div>
                        <span class="status-pill status-pantauan flex-shrink-0">{{ number_format((float) $risiko['peluang_lulus'], 1) }}%</span>
                    </div>
                @endforeach
            </div>
            @if ($totalBerisiko > $mahasiswaBerisiko->count())
                <div class="small text-muted mt-2">Menampilkan 5 mahasiswa dengan peluang terendah.</div>
            @endif
        </section>
    @endif

    <section class="content-section">
        <div class="row g-4">
            <div class="col-xl-8" id="mahasiswa">
                <div class="panel">
                    <div class="panel-heading d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h2 class="panel-title mb-1">Pemantauan mahasiswa</h2>
                            <p class="panel-subtitle mb-0">Tinjau capaian akademik dan indikasi kelulusan setiap mahasiswa.</p>
                        </div>
                        <button class="btn btn-sun btn-sm rounded-pill px-3" type="button" data-bs-toggle="modal" data-bs-target="#mahasiswaModal">
                            <i class="bi bi-plus-lg me-1"></i>Tambah mahasiswa
                        </button>
                    </div>
                    <div class="panel-body">
                        <form method="GET" action="{{ route('dashboard') }}" class="row g-2 align-items-center mb-3">
                            <div class="col-sm-6 col-lg-4">
                                <label class="visually-hidden" for="cariMahasiswa">Cari NIM atau nama mahasiswa</label>
                                <input class="form-control form-control-sm" id="cariMahasiswa" name="q" value="{{ $searchFilter }}" placeholder="Cari NIM atau nama...">
                            </div>
                            <div class="col-6 col-sm-3 col-lg-2">
                                <label class="visually-hidden" for="angkatanFilter">Filter angkatan</label>
                                <select class="form-select form-select-sm" id="angkatanFilter" name="angkatan">
                                    <option value="">Semua angkatan</option>
                                    @foreach ($daftarAngkatan as $angkatan)
                                        <option value="{{ $angkatan }}" @selected((string) $angkatanFilter === (string) $angkatan)>Angkatan {{ $angkatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-sm-3 col-lg-2">
                                <label class="visually-hidden" for="statusFilter">Filter status prediksi</label>
                                <select class="form-select form-select-sm" id="statusFilter" name="status">
                                    <option value="all" @selected($statusFilter === 'all')>Semua status</option>
                                    <option value="lulus" @selected($statusFilter === 'lulus')>Berpotensi lulus</option>
                                    <option value="pantauan" @selected($statusFilter === 'pantauan')>Peluang di bawah 85%</option>
                                    <option value="belum" @selected($statusFilter === 'belum')>Belum diprediksi</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-lg-2">
                                <label class="visually-hidden" for="sortFilter">Urutkan data mahasiswa</label>
                                <select class="form-select form-select-sm" id="sortFilter" name="urutkan">
                                    <option value="nim" @selected($sortFilter === 'nim')>Urutkan: NIM</option>
                                    <option value="nama" @selected($sortFilter === 'nama')>Urutkan: Nama</option>
                                    <option value="angkatan" @selected($sortFilter === 'angkatan')>Urutkan: Angkatan</option>
                                    <option value="ipk" @selected($sortFilter === 'ipk')>Urutkan: IPK tertinggi</option>
                                    <option value="peluang" @selected($sortFilter === 'peluang')>Urutkan: Peluang tertinggi</option>
                                </select>
                            </div>
                            @if ($user->role === 'dosen')
                                <div class="col-sm-6 col-lg-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hanya_bimbingan" value="1" id="hanyaBimbingan" @checked($hanyaBimbingan)>
                                        <label class="form-check-label small text-muted" for="hanyaBimbingan">Bimbingan saya</label>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 d-flex flex-wrap align-items-center gap-2">
                                <button class="btn btn-primary btn-sm rounded-pill px-3" type="submit"><i class="bi bi-funnel me-1"></i>Terapkan</button>
                                <a class="btn btn-outline-secondary btn-sm rounded-pill px-3" href="{{ route('dashboard') }}">Reset filter</a>
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3 ms-sm-auto" type="button" id="exportMahasiswa" title="Ekspor baris pada halaman ini"><i class="bi bi-download me-1"></i>Ekspor halaman</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr><th>NIM</th><th>Nama mahasiswa</th><th>Angkatan</th><th>IPK</th><th>SKS lulus</th><th>Peluang</th><th>Indikasi</th><th>Aksi</th></tr>
                                </thead>
                                <tbody>
                                @forelse ($barisGabungan as $baris)
                                    @php $mhs = $baris['model']; @endphp
                                    <tr>
                                        <td data-label="NIM" class="text-nowrap">{{ $mhs->nim }}</td>
                                        <td data-label="Nama mahasiswa"><span class="student-name">{{ $mhs->nama }}</span></td>
                                        <td data-label="Angkatan">{{ $mhs->angkatan }}</td>
                                        <td data-label="IPK">{{ number_format((float) $mhs->ipk, 2) }}</td>
                                        <td data-label="SKS lulus">{{ $mhs->sks_lulus }} / {{ $mhs->sks_diambil }}</td>
                                        <td data-label="Peluang kelulusan" class="fw-bold text-nowrap">{{ $baris['peluang_lulus'] !== null ? number_format((float) $baris['peluang_lulus'], 1).'%' : 'Belum tersedia' }}</td>
                                        <td data-label="Status prediksi">
                                            @if ($baris['status_prediksi'] === 'Berpotensi Lulus Tepat Waktu')
                                                <span class="status-pill status-lulus">Berpotensi</span>
                                            @elseif ($baris['status_prediksi'] === 'Belum Diprediksi')
                                                <span class="status-pill status-belum">Belum diprediksi</span>
                                            @else
                                                <span class="status-pill status-pantauan">Perlu ditinjau</span>
                                            @endif
                                        </td>
                                        <td data-label="Aksi">
                                            <button
                                                class="btn btn-link btn-sm text-primary p-1"
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editMahasiswaModal"
                                                data-update-url="{{ route('mahasiswa.update', $mhs) }}"
                                                data-nim="{{ $mhs->nim }}"
                                                data-nama="{{ $mhs->nama }}"
                                                data-angkatan="{{ $mhs->angkatan }}"
                                                data-dosen-wali-id="{{ $mhs->dosen_wali_id }}"
                                                data-ipk="{{ $mhs->ipk }}"
                                                data-sks-diambil="{{ $mhs->sks_diambil }}"
                                                data-sks-lulus="{{ $mhs->sks_lulus }}"
                                                data-jumlah-e="{{ $mhs->jumlah_e }}"
                                                data-jumlah-d-cd="{{ $mhs->jumlah_d_cd }}"
                                                data-jumlah-c="{{ $mhs->jumlah_c }}"
                                                data-rata-rata-inti="{{ $mhs->rata_rata_inti }}"
                                                title="Ubah data mahasiswa"
                                                aria-label="Ubah data {{ $mhs->nama }}"
                                            ><i class="bi bi-pencil-square"></i></button>
                                            <form method="POST" action="{{ route('mahasiswa.destroy', $mhs) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link btn-sm text-danger p-1" type="submit" title="Hapus data mahasiswa" aria-label="Hapus data {{ $mhs->nama }}"><i class="bi bi-trash3"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                            @if ($searchFilter !== '' || $angkatanFilter || $statusFilter !== 'all' || $hanyaBimbingan)
                                                <div class="fw-bold text-dark">Data tidak ditemukan</div>
                                                <div class="small mt-1">Coba ubah kata kunci atau filter yang dipilih.</div>
                                                <a class="btn btn-outline-secondary btn-sm rounded-pill px-3 mt-3" href="{{ route('dashboard') }}">Reset filter</a>
                                            @else
                                                <div class="fw-bold text-dark">Belum ada data mahasiswa</div>
                                                <div class="small mt-1">Tambahkan data mahasiswa untuk mulai memantau progres akademik.</div>
                                                <button class="btn btn-primary btn-sm rounded-pill px-3 mt-3" type="button" data-bs-toggle="modal" data-bs-target="#mahasiswaModal">
                                                    <i class="bi bi-plus-lg me-1"></i>Tambah mahasiswa
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                            <div class="small text-muted">{{ $barisGabungan->total() }} data sesuai filter · hasil per halaman {{ $barisGabungan->count() }}</div>
                            {{ $barisGabungan->links('pagination::bootstrap-5') }}
                        </div>
                        <div class="small text-muted mt-2"><i class="bi bi-info-circle me-1"></i>Hasil prediksi merupakan bahan pertimbangan pendampingan, bukan keputusan akademik final.</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="panel mb-4" id="simulasi">
                    <div class="panel-heading">
                        <div class="d-flex align-items-center gap-2">
                            <span class="model-symbol"><i class="bi bi-stars"></i></span>
                            <div>
                                <h2 class="panel-title mb-1">Simulasi kelulusan</h2>
                                <p class="panel-subtitle mb-0">Perkirakan peluang dari profil akademik.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('simulasi') }}">
                            @csrf
                            <div class="row g-2">
                            @foreach ([['ipk','IPK','0','4','0.01','Skala 0–4'],['sks_diambil','SKS ditempuh','1','200','1','Jumlah SKS yang telah diambil'],['sks_lulus','SKS lulus','0','200','1','Jumlah SKS yang dinyatakan lulus'],['jumlah_e','Jumlah nilai E','0','50','1','Masukkan jumlah mata kuliah'],['jumlah_d_cd','Jumlah nilai D/CD','0','50','1','Masukkan jumlah mata kuliah'],['jumlah_c','Jumlah nilai C','0','50','1','Masukkan jumlah mata kuliah'],['rata_rata_inti','Rata-rata mata kuliah inti','0','4','0.01','Skala 0–4']] as $field)
                                    <div class="{{ $field[0] === 'rata_rata_inti' ? 'col-12' : 'col-6' }}">
                                        <label class="form-label mb-1" for="simulasi_{{ $field[0] }}">{{ $field[1] }}</label>
                                        <input type="number" id="simulasi_{{ $field[0] }}" name="{{ $field[0] }}" value="{{ old($field[0]) }}" min="{{ $field[2] }}" max="{{ $field[3] }}" step="{{ $field[4] }}" class="form-control form-control-sm" required>
                                    <div class="form-text small">{{ $field[5] }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="btn btn-primary rounded-pill w-100 mt-3 py-2 fw-bold" type="submit"><i class="bi bi-lightning-charge-fill me-2"></i>Hitung estimasi</button>
                        </form>
                        @if (session('hasil_simulasi'))
                            @php $hasil = session('hasil_simulasi'); @endphp
                            <div class="alert alert-primary mt-3 mb-0 border-0" role="status">
                                <div class="fw-bold mb-1"><i class="bi bi-clipboard2-check me-1"></i>Hasil simulasi</div>
                                <div class="small">{{ $hasil['status_prediksi'] ?? 'Prediksi selesai' }}</div>
                                <div class="fs-4 fw-bold mt-1">{{ isset($hasil['peluang_lulus']) ? number_format((float) $hasil['peluang_lulus'], 1).'%' : '-' }}</div>
                                <div class="small">estimasi peluang kelulusan</div>
                            </div>
                        @endif
                        <p class="small text-muted mt-3 mb-0"><i class="bi bi-info-circle me-1"></i>Simulasi tidak menyimpan data. Gunakan hasilnya sebagai referensi awal.</p>
                    </div>
                </div>

            </div>
        </div>

        @if ($user->role === 'admin')
            <section class="panel model-panel mt-4" id="model" aria-labelledby="modelTitle">
                <div class="panel-heading d-flex align-items-center gap-3">
                    <span class="model-symbol"><i class="bi bi-cpu"></i></span>
                    <div>
                        <h2 class="panel-title mb-1" id="modelTitle">Manajemen model</h2>
                        <p class="panel-subtitle mb-0">Latih dan evaluasi model prediksi menggunakan data alumni dengan hasil kelulusan yang diketahui.</p>
                    </div>
                </div>
                <div class="panel-body">
                    @if ($metaModel)
                        <div class="alert alert-success small mb-4">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Model prediksi aktif.
                            @if (!empty($metaModel['waktu_latih'] ?? $metaModel['trained_at'] ?? null))
                                Pelatihan terakhir: {{ $metaModel['waktu_latih'] ?? $metaModel['trained_at'] }}.
                            @endif
                        </div>
                    @else
                        <div class="alert alert-light border small mb-4">
                            <i class="bi bi-info-circle me-1"></i>
                            Panel ini mengatur pelatihan Random Forest. Layanan prediksi belum aktif atau model belum tersedia, sehingga prediksi dan metrik terbaru belum dapat ditampilkan.
                        </div>
                    @endif

                    <div class="row g-4 align-items-start">
                        <div class="col-lg-4">
                            <div class="model-subpanel h-100">
                                <h3 class="model-subtitle">Konfigurasi pelatihan</h3>
                                <p class="small text-muted mb-3">Jumlah pohon menentukan banyaknya decision tree, kedalaman membatasi kompleksitas, dan random state membantu mengulang hasil yang sama.</p>
                                <form method="POST" action="{{ route('admin.train') }}">
                                    @csrf
                                    <div class="row g-2 mb-2">
                                        <div class="col-12 col-sm-4">
                                            <label class="form-label mb-1" for="n_estimators">Jumlah pohon</label>
                                            <input class="form-control form-control-sm" id="n_estimators" name="n_estimators" type="number" min="10" max="500" value="{{ old('n_estimators', 100) }}" required>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <label class="form-label mb-1" for="max_depth">Kedalaman maks.</label>
                                            <input class="form-control form-control-sm" id="max_depth" name="max_depth" type="number" min="1" max="50" value="{{ old('max_depth', 5) }}">
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <label class="form-label mb-1" for="random_state">Random state</label>
                                            <input class="form-control form-control-sm" id="random_state" name="random_state" type="number" min="0" max="9999" value="{{ old('random_state', 42) }}" required>
                                        </div>
                                    </div>
                                    <div class="form-text small mb-3">Kosongkan kedalaman maksimum jika batas pohon tidak ingin ditentukan.</div>
                                    <button class="btn btn-primary rounded-pill btn-sm w-100 fw-bold" type="submit"><i class="bi bi-arrow-repeat me-1"></i>Latih model</button>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="model-subpanel h-100">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <div>
                                        <h3 class="model-subtitle mb-1">Data latih</h3>
                                        <p class="small text-muted mb-0">Alumni dengan hasil kelulusan yang sudah diketahui.</p>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge rounded-pill text-bg-light">{{ $dataLatih->count() }} data</span>
                                        <button class="btn btn-outline-primary btn-sm rounded-pill" type="button" data-bs-toggle="modal" data-bs-target="#dataLatihModal" aria-label="Tambah data latih"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>
                                <div class="training-table table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead><tr><th>NIM</th><th>Nama</th><th>Hasil</th><th></th></tr></thead>
                                        <tbody>
                                        @forelse ($dataLatih as $latih)
                                            <tr>
                                                <td>{{ $latih->nim }}</td>
                                                <td>{{ $latih->nama }}</td>
                                                <td>{{ $latih->status_kelulusan ? 'Lulus' : 'Belum lulus' }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.latih.destroy', $latih) }}" onsubmit="return confirm('Hapus data latih ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-link btn-sm text-danger p-0" type="submit" title="Hapus data latih" aria-label="Hapus data latih {{ $latih->nim }}"><i class="bi bi-trash3"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data latih.</td></tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="model-subpanel h-100">
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                                    <h3 class="model-subtitle mb-0">Riwayat & evaluasi</h3>
                                    <span class="small text-muted">5 terakhir</span>
                                </div>
                                @forelse ($modelTrainingRuns as $run)
                                    @php $metrics = $run->evaluation_metrics ?? []; @endphp
                                    <article class="history-run">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                            <span class="badge rounded-pill text-bg-primary">Versi #{{ $run->id }}</span>
                                            <span class="small text-muted">{{ $run->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <div class="small text-muted mt-2">
                                            {{ $run->training_samples }} data latih
                                            @if ($run->evaluation_samples)
                                                · {{ $run->evaluation_samples }} data evaluasi
                                            @endif
                                            · {{ $run->trained_by ?? 'Administrator' }}
                                        </div>
                                        @if (isset($metrics['accuracy']))
                                            <div class="history-metrics">
                                                <div class="history-metric"><span class="history-metric-label">Akurasi</span><span class="history-metric-value">{{ number_format((float) $metrics['accuracy'], 2) }}%</span></div>
                                                <div class="history-metric"><span class="history-metric-label">Presisi</span><span class="history-metric-value">{{ number_format((float) $metrics['precision'], 2) }}%</span></div>
                                                <div class="history-metric"><span class="history-metric-label">Recall</span><span class="history-metric-value">{{ number_format((float) $metrics['recall'], 2) }}%</span></div>
                                                <div class="history-metric"><span class="history-metric-label">F1-score</span><span class="history-metric-value">{{ number_format((float) $metrics['f1_score'], 2) }}%</span></div>
                                            </div>
                                            <details class="small mt-2">
                                                <summary class="text-primary">Rincian evaluasi</summary>
                                                <div class="text-muted mt-2">
                                                    <div>Metode: {{ $run->evaluation_method }}</div>
                                                    @if (!empty($metrics['warning']))
                                                        <div class="text-warning-emphasis mt-1">{{ $metrics['warning'] }}</div>
                                                    @endif
                                                    @if (!empty($metrics['confusion_matrix']['matrix']))
                                                        <div class="mt-1">Confusion matrix (baris aktual, kolom prediksi; urutan: belum lulus, lulus):</div>
                                                        @foreach ($metrics['confusion_matrix']['matrix'] as $matrixRow)
                                                            <div class="font-monospace">[{{ implode(', ', $matrixRow) }}]</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </details>
                                        @else
                                            <div class="small text-warning-emphasis mt-2">
                                                {{ $metrics['warning'] ?? 'Metrik evaluasi belum tersedia untuk pelatihan ini.' }}
                                            </div>
                                        @endif
                                    </article>
                                @empty
                                    <div class="small text-muted border rounded-3 bg-white p-3">Belum ada riwayat pelatihan model.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </section>
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <div class="footer-brand">
            <span class="footer-mark"><i class="bi bi-mortarboard-fill"></i></span>
            <div>
                <div class="footer-title">Pusat Prediksi Kelulusan</div>
                <div class="footer-copy">Program Studi Sistem Informasi</div>
            </div>
        </div>
        <p class="footer-note">Informasi prediksi membantu pendampingan akademik. Keputusan tetap mempertimbangkan evaluasi dosen dan kondisi mahasiswa.</p>
        <a class="footer-link" href="#top" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">Kembali ke atas <i class="bi bi-arrow-up"></i></a>
    </div>
</footer>

<div class="modal fade" id="mahasiswaModal" tabindex="-1" aria-labelledby="mahasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" action="{{ route('mahasiswa.store') }}">
                @csrf
                <div class="modal-header px-4 py-3">
                    <div>
                        <h2 class="modal-title fs-5 fw-bold" id="mahasiswaModalLabel">Tambah data mahasiswa</h2>
                        <p class="small text-muted mb-0">Lengkapi informasi akademik untuk pemantauan dan prediksi.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label" for="nim">NIM</label><input id="nim" class="form-control" name="nim" value="{{ old('nim') }}" required></div>
                        <div class="col-md-8"><label class="form-label" for="nama">Nama lengkap</label><input id="nama" class="form-control" name="nama" value="{{ old('nama') }}" required></div>
                        <div class="col-md-4"><label class="form-label" for="angkatan">Angkatan</label><input id="angkatan" type="number" class="form-control" name="angkatan" value="{{ old('angkatan') }}" min="2000" max="2100" required></div>
                        <div class="col-md-8"><label class="form-label" for="dosen_wali_id">Dosen wali</label><select id="dosen_wali_id" class="form-select" name="dosen_wali_id"><option value="">Pilih dosen wali</option>@foreach ($daftarDosen as $dosen)<option value="{{ $dosen->id }}" @selected(old('dosen_wali_id') == $dosen->id)>{{ $dosen->name }}</option>@endforeach</select></div>
                        <div class="col-12"><hr class="my-1"><div class="small fw-bold text-dark">Capaian akademik</div></div>
                        <div class="col-md-4"><label class="form-label" for="ipk">IPK</label><input id="ipk" type="number" step="0.01" class="form-control" name="ipk" value="{{ old('ipk') }}" min="0" max="4" required></div>
                        <div class="col-md-4"><label class="form-label" for="sks_diambil">SKS ditempuh</label><input id="sks_diambil" type="number" class="form-control" name="sks_diambil" value="{{ old('sks_diambil') }}" min="1" max="200" required></div>
                        <div class="col-md-4"><label class="form-label" for="sks_lulus">SKS lulus</label><input id="sks_lulus" type="number" class="form-control" name="sks_lulus" value="{{ old('sks_lulus') }}" min="0" max="200" required></div>
                        <div class="col-md-4"><label class="form-label" for="jumlah_e">Jumlah nilai E</label><input id="jumlah_e" type="number" class="form-control" name="jumlah_e" value="{{ old('jumlah_e') }}" min="0" max="50" required></div>
                        <div class="col-md-4"><label class="form-label" for="jumlah_d_cd">Jumlah nilai D/CD</label><input id="jumlah_d_cd" type="number" class="form-control" name="jumlah_d_cd" value="{{ old('jumlah_d_cd') }}" min="0" max="50" required></div>
                        <div class="col-md-4"><label class="form-label" for="jumlah_c">Jumlah nilai C</label><input id="jumlah_c" type="number" class="form-control" name="jumlah_c" value="{{ old('jumlah_c') }}" min="0" max="50" required></div>
                        <div class="col-md-4"><label class="form-label" for="rata_rata_inti">Rata-rata mata kuliah inti</label><input id="rata_rata_inti" type="number" step="0.01" class="form-control" name="rata_rata_inti" value="{{ old('rata_rata_inti') }}" min="0" max="4" required></div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="bi bi-check-lg me-1"></i>Simpan data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editMahasiswaModal" tabindex="-1" aria-labelledby="editMahasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="modal-header px-4 py-3">
                    <div>
                        <h2 class="modal-title fs-5 fw-bold" id="editMahasiswaModalLabel">Ubah data mahasiswa</h2>
                        <p class="small text-muted mb-0">Perbarui informasi akademik mahasiswa.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label" for="edit_nim">NIM</label><input id="edit_nim" class="form-control" readonly></div>
                        <div class="col-md-8"><label class="form-label" for="edit_nama">Nama lengkap</label><input id="edit_nama" class="form-control" name="nama" required></div>
                        <div class="col-md-4"><label class="form-label" for="edit_angkatan">Angkatan</label><input id="edit_angkatan" type="number" class="form-control" name="angkatan" min="2000" max="2100" required></div>
                        <div class="col-md-8"><label class="form-label" for="edit_dosen_wali_id">Dosen wali</label><select id="edit_dosen_wali_id" class="form-select" name="dosen_wali_id"><option value="">Pilih dosen wali</option>@foreach ($daftarDosen as $dosen)<option value="{{ $dosen->id }}">{{ $dosen->name }}</option>@endforeach</select></div>
                        <div class="col-12"><hr class="my-1"><div class="small fw-bold text-dark">Capaian akademik</div></div>
                        <div class="col-md-4"><label class="form-label" for="edit_ipk">IPK</label><input id="edit_ipk" type="number" step="0.01" class="form-control" name="ipk" min="0" max="4" required></div>
                        <div class="col-md-4"><label class="form-label" for="edit_sks_diambil">SKS ditempuh</label><input id="edit_sks_diambil" type="number" class="form-control" name="sks_diambil" min="1" max="200" required></div>
                        <div class="col-md-4"><label class="form-label" for="edit_sks_lulus">SKS lulus</label><input id="edit_sks_lulus" type="number" class="form-control" name="sks_lulus" min="0" max="200" required></div>
                        <div class="col-md-4"><label class="form-label" for="edit_jumlah_e">Jumlah nilai E</label><input id="edit_jumlah_e" type="number" class="form-control" name="jumlah_e" min="0" max="50" required></div>
                        <div class="col-md-4"><label class="form-label" for="edit_jumlah_d_cd">Jumlah nilai D/CD</label><input id="edit_jumlah_d_cd" type="number" class="form-control" name="jumlah_d_cd" min="0" max="50" required></div>
                        <div class="col-md-4"><label class="form-label" for="edit_jumlah_c">Jumlah nilai C</label><input id="edit_jumlah_c" type="number" class="form-control" name="jumlah_c" min="0" max="50" required></div>
                        <div class="col-md-4"><label class="form-label" for="edit_rata_rata_inti">Rata-rata mata kuliah inti</label><input id="edit_rata_rata_inti" type="number" step="0.01" class="form-control" name="rata_rata_inti" min="0" max="4" required></div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="bi bi-check-lg me-1"></i>Simpan perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($user->role === 'admin')
    <div class="modal fade" id="dataLatihModal" tabindex="-1" aria-labelledby="dataLatihModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.latih.store') }}">
                    @csrf
                    <div class="modal-header px-4 py-3">
                        <div>
                            <h2 class="modal-title fs-5 fw-bold" id="dataLatihModalLabel">Tambah data latih</h2>
                            <p class="small text-muted mb-0">Gunakan data alumni dengan status kelulusan yang telah diketahui.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label" for="latih_nim">NIM</label><input id="latih_nim" class="form-control" name="nim" value="{{ old('nim') }}" required></div>
                            <div class="col-md-8"><label class="form-label" for="latih_nama">Nama alumni</label><input id="latih_nama" class="form-control" name="nama" value="{{ old('nama') }}" required></div>
                            <div class="col-md-4"><label class="form-label" for="latih_angkatan">Angkatan</label><input id="latih_angkatan" type="number" class="form-control" name="angkatan" value="{{ old('angkatan') }}" min="2000" max="2100" required></div>
                            <div class="col-md-4"><label class="form-label" for="latih_ipk">IPK</label><input id="latih_ipk" type="number" step="0.01" class="form-control" name="ipk" value="{{ old('ipk') }}" min="0" max="4" required></div>
                            <div class="col-md-4"><label class="form-label" for="latih_sks_diambil">SKS ditempuh</label><input id="latih_sks_diambil" type="number" class="form-control" name="sks_diambil" value="{{ old('sks_diambil') }}" min="1" max="200" required></div>
                            <div class="col-md-4"><label class="form-label" for="latih_sks_lulus">SKS lulus</label><input id="latih_sks_lulus" type="number" class="form-control" name="sks_lulus" value="{{ old('sks_lulus') }}" min="0" max="200" required></div>
                            <div class="col-md-4"><label class="form-label" for="latih_jumlah_e">Jumlah nilai E</label><input id="latih_jumlah_e" type="number" class="form-control" name="jumlah_e" value="{{ old('jumlah_e') }}" min="0" max="50" required></div>
                            <div class="col-md-4"><label class="form-label" for="latih_jumlah_d_cd">Jumlah nilai D/CD</label><input id="latih_jumlah_d_cd" type="number" class="form-control" name="jumlah_d_cd" value="{{ old('jumlah_d_cd') }}" min="0" max="50" required></div>
                            <div class="col-md-4"><label class="form-label" for="latih_jumlah_c">Jumlah nilai C</label><input id="latih_jumlah_c" type="number" class="form-control" name="jumlah_c" value="{{ old('jumlah_c') }}" min="0" max="50" required></div>
                            <div class="col-md-4"><label class="form-label" for="latih_rata_rata_inti">Rata-rata mata kuliah inti</label><input id="latih_rata_rata_inti" type="number" step="0.01" class="form-control" name="rata_rata_inti" value="{{ old('rata_rata_inti') }}" min="0" max="4" required></div>
                            <div class="col-md-8"><label class="form-label" for="status_kelulusan">Status kelulusan</label><select id="status_kelulusan" class="form-select" name="status_kelulusan" required><option value="">Pilih status</option><option value="1" @selected(old('status_kelulusan') === '1')>Lulus tepat waktu</option><option value="0" @selected(old('status_kelulusan') === '0')>Tidak lulus tepat waktu</option></select></div>
                        </div>
                    </div>
                    <div class="modal-footer px-4 py-3">
                        <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="bi bi-check-lg me-1"></i>Simpan data latih</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('[data-distribution-width]').forEach((segment) => {
        const width = Number(segment.dataset.distributionWidth);
        if (Number.isFinite(width)) segment.style.width = `${Math.max(0, Math.min(100, width))}%`;
    });

    document.getElementById('editMahasiswaModal').addEventListener('show.bs.modal', (event) => {
        const trigger = event.relatedTarget;
        const modal = event.currentTarget;
        const form = modal.querySelector('form');
        form.action = trigger.dataset.updateUrl;

        const fields = {
            edit_nim: 'nim',
            edit_nama: 'nama',
            edit_angkatan: 'angkatan',
            edit_dosen_wali_id: 'dosen-wali-id',
            edit_ipk: 'ipk',
            edit_sks_diambil: 'sks-diambil',
            edit_sks_lulus: 'sks-lulus',
            edit_jumlah_e: 'jumlah-e',
            edit_jumlah_d_cd: 'jumlah-d-cd',
            edit_jumlah_c: 'jumlah-c',
            edit_rata_rata_inti: 'rata-rata-inti',
        };

        Object.entries(fields).forEach(([id, attribute]) => {
            modal.querySelector(`#${id}`).value = trigger.getAttribute(`data-${attribute}`) ?? '';
        });
    });

    document.getElementById('exportMahasiswa').addEventListener('click', () => {
        const table = document.querySelector('#mahasiswa table');
        const rows = [...table.querySelectorAll('tr')]
            .filter((row) => row.cells.length > 1)
            .map((row) => [...row.cells].slice(0, -1).map((cell) => {
                let value = cell.innerText.trim();
                if (/^[\s]*[=+\-@\t\r]/.test(value)) value = `'${value}`;
                return `"${value.replaceAll('"', '""')}"`;
            }).join(','));
        const csv = `\uFEFF${rows.join('\r\n')}`;
        const link = document.createElement('a');
        link.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8;' }));
        link.download = `data-mahasiswa-${new Date().toISOString().slice(0, 10)}.csv`;
        link.click();
        setTimeout(() => URL.revokeObjectURL(link.href), 1000);
    });

    document.querySelectorAll('#mobileNavMenu a').forEach((link) => {
        link.addEventListener('click', () => bootstrap.Collapse.getOrCreateInstance('#mobileNavMenu').hide());
    });
</script>
</body>
</html>
