<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kamar - Admin Sandy Hotel</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            /* TEMA ROYAL NAVY & VELVET RED (SELARAS) */
            --primary: #e63946;
            --primary-hover: #c92a36;
            --dark-bg: #020617;
            --card-bg: #0f172a;
            --border-soft: rgba(230, 57, 70, 0.25);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --radius: 16px;
        }

        body {
            background-color: var(--dark-bg);
            background-image: radial-gradient(circle at top right, rgba(230,57,70,0.08), transparent 45%);
            font-family: 'Poppins', sans-serif;
            color: var(--text-light);
        }

        .sidebar { background-color: var(--card-bg); min-height: 100vh; color: white; border-right: 1px solid var(--border-soft); }
        .sidebar h4 { font-family: 'Playfair Display', serif; color: var(--primary); letter-spacing: 1px; }

        .nav-link { color: var(--text-muted); transition: 0.3s; border-radius: 8px; }
        .nav-link:hover, .nav-link.active { color: var(--primary); background: rgba(230, 57, 70, 0.1); }

        .card { border: none; border-radius: var(--radius); background-color: var(--card-bg); border: 1px solid var(--border-soft); box-shadow: 0 10px 30px rgba(0,0,0,0.35); }

        .btn-save { background-color: var(--primary); color: white; font-weight: bold; border-radius: 8px; transition: 0.3s; }
        .btn-save:hover { background-color: var(--primary-hover); color: white; box-shadow: 0 0 10px rgba(230, 57, 70, 0.4); }

        .navbar { background-color: var(--card-bg) !important; border: 1px solid var(--border-soft); font-weight: bold; }
        .navbar-brand { color: var(--primary) !important; }

        .form-label { color: var(--text-light); }
        .form-control, .form-select { background-color: var(--dark-bg); border: 1px solid rgba(255,255,255,0.2); color: var(--text-light); }
        .form-control:focus, .form-select:focus { background-color: var(--dark-bg); color: white; border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.25); }
        .form-control::placeholder { color: #64748b; }
        .form-control[type="file"]::file-selector-button {
            background-color: var(--primary); color: white; border: none; border-radius: 6px;
            padding: 6px 14px; margin-right: 12px; transition: 0.3s;
        }
        .form-control[type="file"]::file-selector-button:hover { background-color: var(--primary-hover); }

        .foto-box { background-color: rgba(230, 57, 70, 0.06) !important; border: 1px solid var(--border-soft) !important; }
        .foto-box .form-label { color: var(--primary) !important; }

        .btn-light { background-color: transparent; border: 1px solid rgba(255,255,255,0.2); color: var(--text-muted) !important; }
        .btn-light:hover { background-color: rgba(255,255,255,0.05); color: var(--text-light) !important; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar p-3">
            <h4 class="text-center py-3"><i class="fas fa-crown"></i> Admin Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="{{ url('/admin') }}"><i class="fas fa-home me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ url('/admin/kamar/tambah') }}"><i class="fas fa-plus me-2"></i> Tambah Kamar</a></li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start" style="color: var(--primary);">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <main class="col-md-10 ms-sm-auto px-md-4">
            <nav class="navbar navbar-expand-lg rounded mt-3 shadow-sm">
                <div class="container-fluid">
                    <span class="navbar-brand text-uppercase">Tambah Fasilitas Kamar</span>
                </div>
            </nav>

            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card p-4 mb-5">
                        <h4 class="text-center mb-4"><i class="fas fa-bed" style="color: var(--primary);"></i> Input Kamar Baru</h4>

                        <form action="{{ url('/admin/kamar/tambah') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Kamar</label>
                                <input type="text" name="name" class="form-control" placeholder="Misal: Suite Presidential" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Kamar</label>
                                <input type="text" name="number" class="form-control" placeholder="Misal: 301" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipe Kamar</label>
                                <select name="type" class="form-select" required>
                                    <option value="One">One (Single)</option>
                                    <option value="Studio">Studio</option>
                                    <option value="Two">Two (Double)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga per Malam (IDR)</label>
                                <input type="number" name="price" class="form-control" placeholder="Misal: 750000" min="0" required>
                            </div>

                            <div class="mb-4 p-3 rounded border foto-box">
                                <label class="form-label fw-bold"><i class="fas fa-camera"></i> Foto Kamar</label>
                                <input type="file" name="foto" class="form-control" accept="image/*" required>
                                <small class="text-muted d-block mt-1">Format: JPG, PNG. Ukuran maksimal 2MB.</small>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-save py-2"><i class="fas fa-save me-2"></i> Simpan Data Kamar</button>
                                <a href="{{ url('/admin') }}" class="btn btn-light py-2 border">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>