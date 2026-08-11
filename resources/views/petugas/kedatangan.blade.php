<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kedatangan - Petugas Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            /* TEMA ROYAL NAVY & VELVET RED */
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

        /* Main Content & Topbar */
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: var(--card-bg); padding: 15px 30px; border-radius: 15px;
            margin-bottom: 30px; border: 1px solid var(--border-soft);
        }

        /* Panel Area & DataTables */
        .panel-card {
            background-color: var(--card-bg); border-radius: 15px; padding: 25px;
            border: 1px solid var(--border-soft); margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .panel-title { font-weight: 600; color: var(--primary); margin-bottom: 20px; font-size: 1.2rem; }
        
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
        
        .page-item .page-link { background-color: var(--card-bg); border-color: var(--border-soft); color: var(--text-muted); }
        .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: #ffffff; font-weight: 600; }
        .page-item.disabled .page-link { background-color: var(--dark-bg); border-color: var(--border-soft); color: #475569; }
        
        .form-control, .form-select { background-color: var(--dark-bg); border: 1px solid rgba(255,255,255,0.2); color: var(--text-light); }
        .form-control:focus, .form-select:focus { background-color: var(--dark-bg); color: white; border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.25); }
        
        /* Badge Status */
        .badge-checkin { 
            background-color: rgba(16, 185, 129, 0.15); color: #10b981; 
            border: 1px solid #10b981; padding: 8px 12px; border-radius: 6px; 
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand"><i class="fas fa-crown"></i> SANDY HOTEL</div>
        <div class="text-center mb-4">
            <span class="badge px-3 py-2 rounded-pill" style="background-color: rgba(230, 57, 70, 0.15); border: 1px solid var(--border-soft); color: var(--primary);">
                <i class="fas fa-concierge-bell me-1"></i> Front Desk Panel
            </span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ url('/petugas') }}"><i class="fas fa-desktop me-2"></i> Dashboard Resepsionis</a></li>
            <li><a href="{{ url('/petugas/kedatangan') }}" class="active"><i class="fas fa-sign-in-alt me-2"></i> Jadwal Kedatangan</a></li>
            <li><a href="{{ url('/petugas/kamar-aktif') }}"><i class="fas fa-key me-2"></i> Status Kamar Aktif</a></li>
            <li><a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-2"></i> Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="topbar">
            <div>
                <h4 class="mb-0 fw-bold">Jadwal Kedatangan Tamu</h4>
                <small class="text-muted">Pantau tamu yang telah melunasi pembayaran dan siap Check-In.</small>
            </div>
            <div>
                <span class="me-3 fw-bold" style="color: var(--primary);"><i class="fas fa-user-tie"></i> {{ Auth::user()->name ?? 'Petugas' }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="panel-card">
            <h5 class="panel-title"><i class="fas fa-plane-arrival me-2"></i> Daftar Menunggu Check-In</h5>
            <div class="table-responsive">
                <table id="smartTable" class="table table-hover table-striped align-middle text-center w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-start">Nama Tamu & Kontak</th>
                            <th>No. Kamar</th>
                            <th>Tanggal Masuk</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftarKedatangan ?? [] as $index => $pesanan)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-start">
                                <div class="fw-bold text-light">{{ $pesanan->customer->name ?? 'Tamu Hapus' }}</div>
                                <small class="text-info" style="color: #38bdf8 !important;"><i class="fab fa-whatsapp"></i> {{ $pesanan->customer->phone ?? 'Tidak ada nomor' }}</small>
                            </td>
                            <td><span class="badge" style="background-color: var(--border-soft); color: var(--primary); font-size: 0.9rem;">KM-{{ $pesanan->room->number ?? '0' }}</span></td>
                            <td>
                                <div class="fw-bold" style="color: var(--primary);">{{ date('d M Y', strtotime($pesanan->start_date)) }}</div>
                                <small class="text-muted">Mulai 14:00 WIB</small>
                            </td>
                            <td><span class="badge badge-checkin"><i class="fas fa-check-circle me-1"></i> Terverifikasi</span></td>
                            <td>
                                <button class="btn btn-sm btn-success fw-bold px-4 rounded-pill shadow-sm" style="background-color: #10b981; border: none;"
                                    onclick="confirmCheckIn('{{ $pesanan->customer->name ?? '' }}', 'KM-{{ $pesanan->room->number ?? '' }}', {{ $pesanan->id }})">
                                    <i class="fas fa-key me-1"></i> Serahkan Kunci
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#smartTable').DataTable({
                "language": { 
                    "search": "Cari Tamu:",
                    "lengthMenu": "Tampilkan _MENU_ jadwal",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ jadwal",
                    "infoEmpty": "Menampilkan 0 jadwal",
                    "paginate": {
                        "next": "<i class='fas fa-chevron-right'></i>",
                        "previous": "<i class='fas fa-chevron-left'></i>"
                    },
                    // DataTables yang menghandle tampilan saat kosong
                    "emptyTable": "<div class='py-4'><i class='fas fa-user-clock fa-3x mb-3 text-muted d-block'></i><span class='text-muted'>Belum ada jadwal kedatangan tamu yang terverifikasi hari ini.</span></div>"
                }
            });
        });

        // Fungsi Check-In Sinkron dengan Database
        function confirmCheckIn(nama, kamar, id) {
            Swal.fire({
                title: 'Konfirmasi Check-In',
                text: `Tamu ${nama} akan menempati kamar ${kamar}. Pastikan identitas tamu sudah sesuai.`,
                icon: 'question',
                showCancelButton: true,
                background: '#020617', color: '#fff',
                confirmButtonColor: '#10b981', cancelButtonColor: '#334155',
                confirmButtonText: 'Ya, Serahkan Kunci!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/petugas/reservasi/checkin') }}/" + id;
                }
            })
        }

        @if(session('sukses'))
            Swal.fire({
                icon: 'success', title: 'Berhasil!', text: '{{ session('sukses') }}',
                background: '#020617', color: '#fff', confirmButtonColor: '#e63946'
            });
        @endif
    </script>
</body>
</html>