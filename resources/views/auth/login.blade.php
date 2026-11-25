<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Prediksi Kelulusan SI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-1">Sistem Prediksi Kelulusan</h4>
                    <p class="text-muted small mb-4">Masuk menggunakan akun Admin atau Dosen</p>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-semibold">Masuk</button>
                    </form>

                    <hr class="my-4">
                    <div class="small text-muted">
                        <strong>Akun Uji Coba:</strong><br>
                        Admin: <code>admin@prodi.ac.id</code> / <code>admin123</code><br>
                        Dosen: <code>dosen@prodi.ac.id</code> / <code>dosen123</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>