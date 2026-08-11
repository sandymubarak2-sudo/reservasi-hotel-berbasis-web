<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tamu - Admin Panel</title>

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
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { color: var(--text-muted); margin-bottom: 15px; margin-top: 15px; }
        
        /* Tombol Paginasi Tabel */
        .page-item .page-link { background-color: var(--card-bg); border-color: var(--border-soft); color: var(--text-muted); }
        .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: #ffffff; font-weight: 600; }
        .page-item.disabled .page-link { background-color: var(--dark-bg); border-color: var(--border-soft); color: #475569; }
        
        .form-control, .form-select { background-color: var(--dark-bg); border: 1px solid rgba(255,255,255,0.2); color: var(--text-light); }
        .form-control:focus, .form-select:focus { background-color: var(--dark-bg); color: white; border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.25); }
        
        /* Avatar Placeholder Diselaraskan */
        .avatar-circle {
            width: 42px; height: 42px; border-radius: 50%;
            background-color: rgba(230, 57, 70, 0.15); 
            color: var(--primary);
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 1.1rem; margin-right: 15px; 
            border: 1px solid rgba(230, 57, 70, 0.4);
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
            <li><a href="{{ url('/admin/tamu') }}" class="active"><i class="fas fa-users me-2"></i> Daftar Tamu</a></li>
            <li><a href="{{ url('/admin/keuangan') }}"><i class="fas fa-wallet me-2"></i> Laporan Keuangan</a></li>
            <li><a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-2"></i> Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="topbar">
            <div>
                <h4 class="mb-0 fw-bold">Daftar Tamu</h4>
                <small class="text-muted">Basis data pelanggan yang telah mendaftar dan menginap.</small>
            </div>
            <div>
                <span class="me-3 fw-bold" style="color: var(--primary);"><i class="fas fa-user-shield"></i> {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="panel-card">
            <h5 class="panel-title"><i class="fas fa-address-book me-2"></i> Database Kontak Tamu</h5>
            <div class="table-responsive">
                <table id="smartTable" class="table table-hover table-striped align-middle">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Profil Tamu</th>
                            <th>Email</th>
                            <th>Nomor WhatsApp / HP</th>
                            <th>Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarTamu as $index => $tamu)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($tamu->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-light">{{ $tamu->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $tamu->email }}" class="text-decoration-none" style="color: #38bdf8;">
                                    <i class="far fa-envelope me-1"></i> {{ $tamu->email }}
                                </a>
                            </td>
                            <td>
                                @if($tamu->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tamu->phone) }}" target="_blank" class="text-decoration-none text-success fw-bold">
                                        <i class="fab fa-whatsapp me-1"></i> {{ $tamu->phone }}
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Belum diisi</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background-color: var(--dark-bg); border: 1px solid var(--border-soft); color: var(--text-light); padding: 8px 12px;">
                                    <i class="far fa-calendar-alt me-1" style="color: var(--primary);"></i> 
                                    {{ $tamu->created_at ? $tamu->created_at->format('d M Y') : 'Data Lama' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data tamu yang tersimpan.</td>
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
                    "search": "Cari Nama/Email:",
                    "lengthMenu": "Tampilkan _MENU_ tamu",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ tamu",
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