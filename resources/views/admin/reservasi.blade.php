<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Reservasi - Sandy Hotel Admin</title>

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

        /* Top Navbar */
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: var(--card-bg); padding: 15px 30px; border-radius: 15px;
            margin-bottom: 30px; border: 1px solid var(--border-soft);
        }

        /* Panel Card */
        .panel-card {
            background-color: var(--card-bg); border-radius: 15px; padding: 25px;
            border: 1px solid var(--border-soft); margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .panel-title { font-weight: 600; color: var(--primary); margin-bottom: 20px; font-size: 1.2rem; }

        /* Customizing DataTables for Dark Navy Mode (Menghilangkan Tabel Putih) */
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
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, 
        .dataTables_wrapper .dataTables_paginate { color: var(--text-muted); margin-bottom: 15px; margin-top: 15px; }
        
        /* Tombol Paginasi Tabel */
        .page-item .page-link { background-color: var(--card-bg); border-color: var(--border-soft); color: var(--text-muted); }
        .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: #ffffff; font-weight: 600; }
        .page-item.disabled .page-link { background-color: var(--dark-bg); border-color: var(--border-soft); color: #475569; }
        
        /* Input & Select */
        .form-control, .form-select { background-color: var(--dark-bg); border: 1px solid rgba(255,255,255,0.2); color: var(--text-light); }
        .form-control:focus, .form-select:focus { background-color: var(--dark-bg); color: white; border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.25); }

        /* Badge Custom */
        .badge-lunas { background-color: #10b981; color: #fff; padding: 6px 10px; font-weight: 500; }
        .badge-menunggu { background-color: #f59e0b; color: #000; padding: 6px 10px; font-weight: 500; }
        .badge-verifikasi { background-color: #3b82f6; color: #fff; padding: 6px 10px; font-weight: 500; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand"><i class="fas fa-crown"></i> SANDY HOTEL</div>
        <ul class="sidebar-menu">
            <li><a href="{{ url('/admin') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="{{ url('/admin/reservasi') }}" class="active"><i class="fas fa-history me-2"></i> Data Reservasi</a></li>
            <li><a href="{{ url('/admin/kamar') }}"><i class="fas fa-bed me-2"></i> Manajemen Kamar</a></li>
            <li><a href="{{ url('/admin/tamu') }}"><i class="fas fa-users me-2"></i> Daftar Tamu</a></li>
            <li><a href="{{ url('/admin/keuangan') }}"><i class="fas fa-wallet me-2"></i> Laporan Keuangan</a></li>
            <li><a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-2"></i> Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="topbar">
            <div>
                <h4 class="mb-0 fw-bold">Data Reservasi</h4>
                <small class="text-muted">Pantau transaksi dan verifikasi pembayaran tamu.</small>
            </div>
            <div>
                <span class="me-3 fw-bold" style="color: var(--primary);"><i class="fas fa-user-shield"></i> {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        @if(session('sukses'))
        <div class="alert alert-success bg-success text-white border-0 alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('sukses') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="panel-card">
            <h5 class="panel-title"><i class="fas fa-history me-2"></i> Seluruh Riwayat Pemesanan</h5>
            <div class="table-responsive mt-4">
                <table id="reservasiTable" class="table table-hover table-striped align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Tamu</th>
                            <th width="15%">Kamar</th>
                            <th width="20%">Check In/Out</th>
                            <th width="15%">Total Bayar</th>
                            <th width="15%">Status</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarPesanan ?? [] as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold" style="color: var(--text-light);">{{ $item->customer->name ?? 'Tamu Hapus' }}</div>
                                <small class="text-muted">{{ $item->customer->email ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="fw-bold" style="color: var(--primary);">{{ $item->room->name ?? 'Kamar Hapus' }}</div>
                                <span class="badge bg-secondary opacity-75">{{ $item->room->number ?? '-' }}</span>
                            </td>
                            <td>
                                <div><i class="far fa-calendar-alt text-muted me-1"></i> {{ date('d M Y', strtotime($item->start_date)) }}</div>
                                <div><i class="far fa-calendar-check text-muted me-1"></i> {{ date('d M Y', strtotime($item->end_date)) }}</div>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status == 'Lunas')
                                    <span class="badge badge-lunas"><i class="fas fa-check-circle"></i> Lunas</span>
                                @elseif($item->status == 'Menunggu Pembayaran')
                                    <span class="badge badge-menunggu"><i class="fas fa-clock"></i> Menunggu Bayar</span>
                                @elseif($item->status == 'Menunggu Verifikasi Admin')
                                    <span class="badge badge-verifikasi"><i class="fas fa-spinner fa-spin"></i> Verifikasi</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->bukti_pembayaran)
                                    <button type="button" class="btn btn-sm btn-outline-info rounded-pill" data-bs-toggle="modal" data-bs-target="#modalBukti{{ $item->id }}">
                                        <i class="far fa-image"></i> Bukti
                                    </button>

                                    <div class="modal fade" id="modalBukti{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content" style="background-color: var(--card-bg); border: 1px solid var(--border-soft);">
                                                <div class="modal-header border-bottom-0">
                                                    <h5 class="modal-title text-white">Bukti Transfer - {{ $item->customer->name ?? 'Tamu' }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset($item->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid rounded mb-3 border border-secondary" style="max-height: 400px; object-fit: contain;">
                                                    
                                                    @if($item->status == 'Menunggu Verifikasi Admin')
                                                        <hr style="border-color: rgba(255,255,255,0.1);">
                                                        <p class="text-muted small mb-3">Harap periksa kecocokan nominal transfer sebesar <strong>Rp {{ number_format($item->price, 0, ',', '.') }}</strong></p>
                                                        
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <form action="{{ url('/admin/reservasi/lunas/'.$item->id) }}" method="GET">
                                                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Verifikasi Sah</button>
                                                            </form>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> Tolak</button>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-success py-2 mb-0"><i class="fas fa-check-circle"></i> Pembayaran telah diverifikasi.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted small fst-italic">Belum ada</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data reservasi.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#reservasiTable').DataTable({
                "language": {
                    "search": "Cari Data:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ reservasi",
                    "paginate": {
                        "first": "Awal",
                        "last": "Akhir",
                        "next": "<i class='fas fa-chevron-right'></i>",
                        "previous": "<i class='fas fa-chevron-left'></i>"
                    }
                }
            });
        });
    </script>
</body>
</html>