<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Petugas Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            /* TEMA SANDY HOTEL: VELVET RED & ROYAL NAVY */
            --primary: #e63946; 
            --dark-bg: #020617; 
            --card-bg: #0f172a; 
            --text-light: #f8fafc; 
            --border-soft: rgba(230, 57, 70, 0.25); 
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
            font-size: 1.5rem; font-weight: 800; color: var(--primary);
            text-align: center; margin-bottom: 30px; letter-spacing: 2px;
        }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li { margin-bottom: 10px; }
        .sidebar-menu a {
            display: block; padding: 15px 25px; color: #94a3b8; text-decoration: none;
            transition: 0.3s; font-weight: 500; border-left: 4px solid transparent;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            color: var(--primary); background: rgba(230, 57, 70, 0.1); border-left-color: var(--primary);
        }

        /* Main Content */
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: var(--card-bg); padding: 15px 30px; border-radius: 15px;
            margin-bottom: 30px; border: 1px solid rgba(255,255,255,0.05);
        }

        /* Gradient Cards Khusus Resepsionis */
        .stat-card {
            border-radius: 15px; padding: 25px; position: relative; overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); color: white; border: none;
        }
        .card-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); } 
        .card-red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); } 
        .card-blue { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); } 
        
        .stat-icon {
            position: absolute; right: -10px; bottom: -20px; font-size: 8rem;
            opacity: 0.15; transform: rotate(-15deg);
        }

        /* Chart & Table Area */
        .panel-card {
            background-color: var(--card-bg); border-radius: 15px; padding: 25px;
            border: 1px solid var(--border-soft); margin-bottom: 30px;
        }

        /* Customizing DataTables for Dark Mode */
        .table { color: var(--text-light); margin-bottom: 0; }
        .table thead { background-color: rgba(230, 57, 70, 0.1); color: var(--primary); border-bottom: 2px solid var(--primary); }
        .table thead th { padding: 15px; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; }
        .table tbody td { border-bottom: 1px solid rgba(255,255,255,0.05); padding: 15px; vertical-align: middle; }
        .table-striped>tbody>tr:nth-of-type(odd)>* { background-color: rgba(255, 255, 255, 0.02); color: var(--text-light); }
        .table-hover>tbody>tr:hover>* { background-color: rgba(230, 57, 70, 0.05); color: white; }
        
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { color: #94a3b8; margin-bottom: 15px; margin-top: 15px; }
        .page-item .page-link { background-color: var(--card-bg); border-color: var(--border-soft); color: #94a3b8; }
        .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: #fff; font-weight: 600; }
        .page-item.disabled .page-link { background-color: var(--dark-bg); border-color: var(--border-soft); color: #475569; }
        
        .form-control, .form-select { background-color: var(--dark-bg); border: 1px solid rgba(255,255,255,0.2); color: var(--text-light); }
        .form-control:focus, .form-select:focus { background-color: var(--dark-bg); color: white; border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.25); }
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
            <li><a href="{{ url('/petugas') }}" class="active"><i class="fas fa-desktop me-2"></i> Dashboard Resepsionis</a></li>
            <li><a href="{{ url('/petugas/kedatangan') }}"><i class="fas fa-sign-in-alt me-2"></i> Jadwal Kedatangan</a></li>
            <li><a href="{{ url('/petugas/kamar-aktif') }}"><i class="fas fa-key me-2"></i> Status Kamar Aktif</a></li>
            <li><a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-2"></i> Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="topbar">
            <div>
                <h4 class="mb-0 fw-bold">Halo, Resepsionis!</h4>
                <small class="text-muted">Jadwal operasional hotel hari ini: <strong style="color: var(--text-light);">{{ date('d F Y') }}</strong></small>
            </div>
            <div>
                <span class="me-3 fw-bold" style="color: var(--primary);"><i class="fas fa-user-tie"></i> {{ Auth::user()->name ?? 'Petugas' }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 shadow-sm"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card card-green">
                    <i class="fas fa-door-open stat-icon"></i>
                    <p class="mb-1 fw-bold text-white text-uppercase" style="letter-spacing: 1px;">Kedatangan Hari Ini</p>
                    <h2 class="fw-bold mb-0 text-white">{{ count($kedatanganHariIni ?? []) }} <small class="fs-6 text-white-50">Tamu</small></h2>
                    <small class="text-white-50"><i class="fas fa-info-circle"></i> Menunggu Check-In</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card-red">
                    <i class="fas fa-sign-out-alt stat-icon"></i>
                    <p class="mb-1 fw-bold text-white text-uppercase" style="letter-spacing: 1px;">Pemesanan Baru</p>
                    <h2 class="fw-bold mb-0 text-white">{{ $pesananBaru ?? 0 }} <small class="fs-6 text-white-50">Tamu</small></h2>
                    <small class="text-white-50"><i class="fas fa-info-circle"></i> Menunggu Verifikasi Admin</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card-blue">
                    <i class="fas fa-bed stat-icon"></i>
                    <p class="mb-1 fw-bold text-white text-uppercase" style="letter-spacing: 1px;">Total Transaksi</p>
                    <h2 class="fw-bold mb-0 text-white">{{ $totalPesanan ?? 0 }} <small class="fs-6 text-white-50">Pesanan</small></h2>
                    <small class="text-white-50"><i class="fas fa-info-circle"></i> Seluruh riwayat reservasi</small>
                </div>
            </div>
        </div>

        <div class="panel-card">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 1px solid var(--border-soft);">
                <div>
                    <h5 class="fw-bold mb-1" style="color: var(--primary); font-size: 1.3rem; letter-spacing: 0.5px;">
                        <i class="fas fa-calendar-check me-2"></i> Jadwal Operasional
                    </h5>
                    <small class="text-muted" style="font-size: 0.85rem;">
                        <i class="fas fa-server me-1"></i> Tersinkronisasi dengan <span class="text-light">Database Hotel</span>
                    </small>
                </div>
                <div>
                    <span class="badge rounded-pill shadow-sm" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 8px 15px; font-weight: 500;">
                        <span class="spinner-grow spinner-grow-sm me-1" role="status" style="width: 10px; height: 10px; animation-duration: 1.5s;"></span> 
                        Status: LIVE REAL-TIME
                    </span>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="smartTable" class="table table-hover table-striped align-middle text-center w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-start">Nama Tamu</th>
                            <th>No. Kamar</th>
                            <th>Jadwal</th>
                            <th>Status Lapangan</th>
                            <th>Aksi Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan ?? [] as $index => $p)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-start">
                                <div class="fw-bold text-light">{{ $p->customer->name ?? 'Tamu Hapus' }}</div>
                                <small class="text-muted">INV-{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}</small>
                            </td>
                            <td><span class="badge" style="background-color: var(--border-soft); color: var(--primary);">KM-{{ $p->room->number ?? '0' }} ({{ $p->room->type ?? '-' }})</span></td>
                            <td>
                                @if($p->status == 'Lunas')
                                    <span class="text-success fw-bold">Check-In</span><br><small class="text-muted">{{ date('d M Y', strtotime($p->start_date)) }}, 14:00</small>
                                @elseif($p->status == 'Sedang Menginap')
                                    <span class="text-danger fw-bold">Check-Out</span><br><small class="text-muted">{{ date('d M Y', strtotime($p->end_date)) }}, 12:00</small>
                                @else
                                    <span class="text-light">{{ $p->status }}</span><br><small class="text-muted">{{ date('d M Y', strtotime($p->start_date)) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($p->status == 'Lunas')
                                    <span class="badge" style="background-color: rgba(16, 185, 129, 0.2); color: #10b981; border: 1px solid #10b981;"><i class="fas fa-clock me-1"></i> Belum Datang</span>
                                @elseif($p->status == 'Sedang Menginap')
                                    <span class="badge" style="background-color: rgba(230, 57, 70, 0.2); color: var(--primary); border: 1px solid var(--primary);"><i class="fas fa-bed me-1"></i> Sedang Menginap</span>
                                @elseif($p->status == 'Selesai')
                                    <span class="badge bg-secondary"><i class="fas fa-check-double me-1"></i> Selesai</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-exclamation-circle me-1"></i> Proses Admin</span>
                                @endif

                                @if($p->handled_by)
                                    <div class="mt-2 text-start p-2 rounded shadow-sm" style="background-color: rgba(255,255,255,0.03); border-left: 2px solid var(--primary); font-size: 0.75rem;">
                                        <div class="text-muted mb-1" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px;">Jejak Audit:</div>
                                        <div><i class="fas fa-user-check me-1" style="color: var(--primary);"></i> <strong class="text-light">{{ $p->handled_by }}</strong></div>
                                        <div class="text-muted"><i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::parse($p->handled_at)->format('d M, H:i') }} WIB</div>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($p->status == 'Lunas')
                                    <button class="btn btn-sm btn-success fw-bold px-3 rounded-pill" style="background-color: #10b981; border: none;" onclick="confirmCheckIn('{{ $p->customer->name ?? '' }}', 'KM-{{ $p->room->number ?? '' }}', {{ $p->id }})">
                                        <i class="fas fa-sign-in-alt me-1"></i> Proses Check-In
                                    </button>
                                @elseif($p->status == 'Sedang Menginap')
                                    <button class="btn btn-sm btn-danger fw-bold px-3 rounded-pill" style="background-color: #ef4444; border: none;" onclick="confirmCheckOut('{{ $p->customer->name ?? '' }}', 'KM-{{ $p->room->number ?? '' }}', {{ $p->id }})">
                                        <i class="fas fa-sign-out-alt me-1"></i> Proses Check-Out
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-outline-danger fw-bold px-3 rounded-pill" onclick="confirmDelete('{{ $p->customer->name ?? '' }}', {{ $p->id }})">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </button>
                                @endif
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
            if ($('#smartTable tbody tr').length > 0) {
                $('#smartTable').DataTable({
                    "language": {
                        "search": "Cari Tamu/Kamar:",
                        "lengthMenu": "Tampilkan _MENU_ baris",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "infoEmpty": "Menampilkan 0 jadwal",
                        "paginate": {
                            "next": "<i class='fas fa-chevron-right'></i>",
                            "previous": "<i class='fas fa-chevron-left'></i>"
                        },
                        "emptyTable": "<div class='py-4'><i class='fas fa-calendar-times fa-3x mb-3 text-muted d-block'></i><span class='text-muted'>Belum ada jadwal operasional hari ini.</span></div>"
                    },
                    "order": [[ 0, "desc" ]] 
                });
            }
        });

        function confirmCheckIn(nama, kamar, id) {
            Swal.fire({
                title: 'Verifikasi Kedatangan',
                text: `Tamu ${nama} siap menerima kunci kamar ${kamar}?`,
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

        function confirmCheckOut(nama, kamar, id) {
            Swal.fire({
                title: 'Konfirmasi Check-Out',
                text: `Tamu ${nama} (Kamar ${kamar}) mengembalikan kunci. Pastikan tidak ada tagihan tertunda.`,
                icon: 'warning',
                showCancelButton: true,
                background: '#020617', color: '#fff',
                confirmButtonColor: '#ef4444', cancelButtonColor: '#334155',
                confirmButtonText: 'Ya, Selesai Check-Out!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/petugas/reservasi/checkout') }}/" + id;
                }
            })
        }

        function confirmDelete(nama, id) {
            Swal.fire({
                title: 'Hapus Data Reservasi?',
                text: `Data pesanan atas nama ${nama} akan dihapus secara permanen dari sistem.`,
                icon: 'error',
                showCancelButton: true,
                background: '#020617', color: '#fff',
                confirmButtonColor: '#e63946', cancelButtonColor: '#334155',
                confirmButtonText: 'Ya, Hapus Data!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/petugas/reservasi/hapus') }}/" + id;
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