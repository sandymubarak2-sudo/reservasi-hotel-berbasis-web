<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            /* TEMA ROYAL NAVY & VELVET RED (SELARAS 100%) */
            --primary: #e63946; 
            --primary-hover: #c92a36;
            --dark-bg: #020617; 
            --card-bg: #0f172a; 
            --border-soft: rgba(230, 57, 70, 0.25); 
            --text-light: #f8fafc; 
            --text-muted: #94a3b8; 
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-light);
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 260px; height: 100vh;
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-soft);
            padding-top: 20px;
            z-index: 1000;
        }
        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem; font-weight: 800; color: var(--primary);
            text-align: center; margin-bottom: 30px; letter-spacing: 2px;
        }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li { margin-bottom: 10px; }
        .sidebar-menu a {
            display: block; padding: 15px 25px; color: var(--text-muted); text-decoration: none;
            transition: 0.3s; font-weight: 500; border-left: 4px solid transparent;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            color: var(--primary); background: rgba(230, 57, 70, 0.1); border-left-color: var(--primary);
        }

        /* Main Content */
        .main-content {
            margin-left: 260px; padding: 30px; min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: var(--card-bg); padding: 15px 30px; border-radius: 15px;
            margin-bottom: 30px; border: 1px solid var(--border-soft);
        }

        /* Panel Area */
        .panel-card {
            background-color: var(--card-bg); border-radius: 15px; padding: 25px;
            border: 1px solid var(--border-soft); margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .panel-title { font-weight: 600; color: var(--primary); margin-bottom: 20px; font-size: 1.2rem; }

        /* Kartu Total Keuangan */
        .finance-card {
            background: linear-gradient(135deg, #e63946 0%, #900b16 100%);
            border-radius: 15px; padding: 30px; color: white; position: relative; overflow: hidden;
            box-shadow: 0 10px 30px rgba(230, 57, 70, 0.3); margin-bottom: 30px;
        }
        .finance-icon {
            position: absolute; right: 10px; bottom: -20px; font-size: 10rem;
            opacity: 0.15; transform: rotate(-10deg);
        }

        /* Customizing DataTables for Dark Navy Mode */
        .table { color: var(--text-light); margin-bottom: 0; border-collapse: separate; border-spacing: 0; }
        .table thead { background-color: rgba(230, 57, 70, 0.1); }
        .table thead th { 
            color: var(--primary); border-bottom: 2px solid var(--primary); 
            padding: 15px; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;
        }
        .table tbody td { border-bottom: 1px solid rgba(255,255,255,0.05); padding: 15px; vertical-align: middle; }
        .table-striped>tbody>tr:nth-of-type(odd)>* { background-color: rgba(255, 255, 255, 0.02); color: var(--text-light); }
        .table-hover>tbody>tr:hover>* { background-color: rgba(230, 57, 70, 0.05); color: white; }
        
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { color: var(--text-muted); margin-bottom: 15px; margin-top: 15px;}
        
        /* Tombol Paginasi Tabel */
        .page-item .page-link { background-color: var(--card-bg); border-color: var(--border-soft); color: var(--text-muted); }
        .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: #ffffff; font-weight: 600; }
        .page-item.disabled .page-link { background-color: var(--dark-bg); border-color: var(--border-soft); color: #475569; }
        
        .form-control, .form-select { background-color: var(--dark-bg); border: 1px solid rgba(255,255,255,0.2); color: var(--text-light); }
        .form-control:focus, .form-select:focus { background-color: var(--dark-bg); color: white; border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.25); }

        /* =========================================
           PRINT MEDIA QUERY (HANYA MUNCUL SAAT DI-PRINT)
           ========================================= */
        @media print {
            body { background-color: white !important; color: black !important; }
            .sidebar, .topbar, .btn, .dataTables_filter, .dataTables_length, .dataTables_info, .dataTables_paginate { display: none !important; }
            .main-content { margin-left: 0 !important; padding: 0 !important; }
            .panel-card { box-shadow: none !important; border: none !important; padding: 0 !important; background-color: transparent !important; }
            .finance-card { background: none !important; border: 2px solid black !important; color: black !important; box-shadow: none !important; }
            .finance-icon { display: none !important; }
            .table { color: black !important; border: 1px solid #ddd !important; }
            .table thead th { background-color: #f8f9fa !important; color: black !important; -webkit-print-color-adjust: exact; border-bottom: 2px solid black !important; }
            .table tbody td { border-bottom: 1px solid #ddd !important; }
            .table-striped>tbody>tr:nth-of-type(odd)>* { color: black !important; background-color: transparent !important; }
            .badge { border: 1px solid black !important; color: black !important; background: transparent !important; -webkit-print-color-adjust: exact; }
            .text-warning, .text-success, .text-danger, .text-light, .text-muted { color: black !important; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand"><i class="fas fa-crown"></i> SANDY HOTEL</div>
        <ul class="sidebar-menu">
            <li><a href="{{ url('/admin') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="{{ url('/admin/reservasi') }}"><i class="fas fa-calendar-check me-2"></i> Data Reservasi</a></li>
            <li><a href="{{ url('/admin/kamar') }}"><i class="fas fa-bed me-2"></i> Manajemen Kamar</a></li>
            <li><a href="{{ url('/admin/tamu') }}"><i class="fas fa-users me-2"></i> Daftar Tamu</a></li>
            <li><a href="{{ url('/admin/keuangan') }}" class="active"><i class="fas fa-wallet me-2"></i> Laporan Keuangan</a></li>
            <li><a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-2"></i> Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="topbar">
            <div>
                <h4 class="mb-0 fw-bold">Laporan Keuangan</h4>
                <small class="text-muted">Rekapitulasi pendapatan dan riwayat transaksi hotel.</small>
            </div>
            <div>
                <span class="me-3 fw-bold" style="color: var(--primary);"><i class="fas fa-user-shield"></i> {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="finance-card">
                    <i class="fas fa-money-bill-wave finance-icon"></i>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 fw-bold text-uppercase" style="letter-spacing: 2px;">Total Pendapatan Bersih (Lunas)</p>
                            <h1 class="display-4 fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h1>
                        </div>
                        
                        <div class="d-flex gap-3">
                            <a href="{{ url('/admin/export-laporan') }}" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm" style="background-color: #10b981; color: white; border: none; transition: 0.3s;">
                                <i class="fas fa-file-excel me-2"></i> Download Excel
                            </a>
                            <button onclick="window.print()" class="btn btn-light btn-lg rounded-pill fw-bold shadow-sm" style="color: var(--primary);">
                                <i class="fas fa-print me-2"></i> Cetak Laporan
                            </button>
                        </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="panel-card">
            <h5 class="panel-title"><i class="fas fa-file-invoice-dollar me-2"></i> Rincian Transaksi Masuk</h5>
            <div class="table-responsive">
                <table id="smartTable" class="table table-hover table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No. Invoice</th>
                            <th>Tanggal Dibuat</th>
                            <th>Nama Tamu</th>
                            <th>Kamar (Tipe)</th>
                            <th>Status Pembayaran</th>
                            <th class="text-end">Nominal Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarPesanan as $pesanan)
                        <tr>
                            <td class="fw-bold text-light">INV-{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : 'Tanggal Lama' }}</td>
                            <td class="fw-bold">{{ $pesanan->customer->name ?? 'Tamu Hapus' }}</td>
                            <td>{{ $pesanan->room->name ?? 'Kamar Hapus' }}</td>
                            <td>
                                @if($pesanan->status == 'Lunas' || $pesanan->status == 'Selesai')
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Lunas</span>
                                @elseif($pesanan->status == 'Menunggu Verifikasi Admin')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-spinner fa-spin me-1"></i> Proses Verifikasi</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Belum Lunas</span>
                                @endif
                            </td>
                            <td class="text-end fw-bold fs-5" style="color: var(--primary);">
                                Rp {{ number_format($pesanan->price, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi yang tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#smartTable').DataTable({
                "language": {
                    "search": "Cari Invoice/Tamu:",
                    "lengthMenu": "Tampilkan _MENU_ transaksi",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ transaksi",
                    "paginate": {
                        "next": "<i class='fas fa-chevron-right'></i>",
                        "previous": "<i class='fas fa-chevron-left'></i>"
                    }
                },
                "order": [[ 0, "desc" ]] // Otomatis mengurutkan dari transaksi terbaru (Invoice terbesar)
            });
        });
    </script>
</body>
</html>