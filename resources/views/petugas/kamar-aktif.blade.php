<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Kamar Aktif - Petugas Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            /* TEMA SANDY HOTEL: ROYAL NAVY & VELVET RED */
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
        
        /* Animasi Berkedip untuk Denda */
        @keyframes blinkWarning {
            0% { opacity: 1; box-shadow: 0 0 10px rgba(239, 68, 68, 0.5); }
            50% { opacity: 0.6; box-shadow: 0 0 20px rgba(239, 68, 68, 0.8); }
            100% { opacity: 1; box-shadow: 0 0 10px rgba(239, 68, 68, 0.5); }
        }
        .denda-alert {
            animation: blinkWarning 1.5s infinite;
            border: 1px solid #ef4444;
            background-color: rgba(239, 68, 68, 0.1);
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
            <li><a href="{{ url('/petugas/kedatangan') }}"><i class="fas fa-sign-in-alt me-2"></i> Jadwal Kedatangan</a></li>
            <li><a href="{{ url('/petugas/kamar-aktif') }}" class="active"><i class="fas fa-key me-2"></i> Status Kamar Aktif</a></li>
            <li><a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-2"></i> Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="topbar">
            <div>
                <h4 class="mb-0 fw-bold">Status Kamar Aktif</h4>
                <small class="text-muted">Pantau tamu yang sedang menginap dan kelola jadwal Check-Out.</small>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="panel-title mb-0"><i class="fas fa-bed me-2"></i> Daftar Tamu Menginap</h5>
                <span class="badge bg-danger rounded-pill px-3 py-2"><i class="fas fa-clock me-1"></i> Waktu Server: <span id="realtime-clock"></span></span>
            </div>
            
            <div class="table-responsive">
                <table id="smartTable" class="table table-hover table-striped align-middle text-center w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-start">Nama Tamu & Kontak</th>
                            <th>No. Kamar</th>
                            <th>Jadwal Check-Out</th>
                            <th>Status & Kalkulasi Denda</th>
                            <th>Aksi Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kamarAktif ?? [] as $index => $pesanan)
                        
                        @php
                            // Mengatur batas waktu ke jam 12:00 siang di tanggal Check-Out
                            $batasWaktu = \Carbon\Carbon::parse($pesanan->end_date)->setTime(12, 0, 0);
                            $sekarang = \Carbon\Carbon::now();
                            $isLate = $sekarang->greaterThan($batasWaktu);
                            $denda = 0;
                            $hariTelat = 0;

                            if($isLate) {
                                $selisihJam = $sekarang->diffInHours($batasWaktu);
                                $hariTelat = ceil($selisihJam / 24);
                                if($hariTelat == 0) $hariTelat = 1; // Lewat jam 12 dihitung 1 hari
                                $denda = $hariTelat * 50000; // Denda Rp 50.000 per hari
                            }
                        @endphp
                        <tr class="{{ $isLate ? 'bg-danger bg-opacity-10' : '' }}">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-start">
                                <div class="fw-bold text-light">{{ $pesanan->customer->name ?? 'Tamu Hapus' }}</div>
                                <small class="text-info" style="color: #e63946 !important;"><i class="fab fa-whatsapp"></i> {{ $pesanan->customer->phone ?? 'Tidak ada nomor' }}</small>
                            </td>
                            <td><span class="badge" style="background-color: var(--border-soft); color: var(--primary); font-size: 0.9rem;">KM-{{ $pesanan->room->number ?? '0' }}</span></td>
                            <td>
                                <div class="fw-bold {{ $isLate ? 'text-danger' : 'text-light' }}" style="{{ !$isLate ? 'color: #e63946;' : '' }}">{{ date('d M Y', strtotime($pesanan->end_date)) }}</div>
                                <small class="{{ $isLate ? 'text-danger fw-bold' : 'text-muted' }}">Maksimal 12:00 WIB</small>
                            </td>
                            <td>
                                @if($isLate)
                                    <div class="p-2 rounded denda-alert">
                                        <div class="text-danger fw-bold mb-1"><i class="fas fa-exclamation-triangle"></i> OVERSTAY ({{ $hariTelat }} Hari)</div>
                                        <div class="badge bg-danger fs-6 w-100">Denda: Rp {{ number_format($denda, 0, ',', '.') }}</div>
                                    </div>
                                @else
                                    <span class="badge" style="background-color: rgba(230, 57, 70, 0.15); color: var(--primary); border: 1px solid var(--primary); padding: 8px 12px; border-radius: 6px;">
                                        <i class="fas fa-bed me-1"></i> Sedang Menginap
                                    </span>
                                    <div class="mt-1"><small class="text-muted"><i class="fas fa-check-circle text-success"></i> Aman (Belum lewat batas)</small></div>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger fw-bold px-4 rounded-pill shadow-sm" style="background-color: #e63946; border: none;"
                                    onclick="confirmCheckOut('{{ $pesanan->customer->name ?? '' }}', 'KM-{{ $pesanan->room->number ?? '' }}', {{ $pesanan->id }}, {{ $denda }})">
                                    <i class="fas fa-sign-out-alt me-1"></i> Proses Check-Out
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
                    "search": "Cari Tamu/Kamar:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ kamar",
                    "infoEmpty": "Menampilkan 0 kamar",
                    "paginate": {
                        "next": "<i class='fas fa-chevron-right'></i>",
                        "previous": "<i class='fas fa-chevron-left'></i>"
                    },
                    "emptyTable": "<div class='py-4'><i class='fas fa-bed fa-3x mb-3 text-muted d-block'></i><span class='text-muted'>Belum ada kamar yang sedang ditempati oleh tamu saat ini.</span></div>"
                }
            });

            // Waktu Server Real-time
            setInterval(function() {
                var date = new Date();
                var time = date.toLocaleTimeString('id-ID', { hour12: false });
                $('#realtime-clock').text(time + ' WIB');
            }, 1000);
        });

        // Fungsi Check-Out dengan Logika Peringatan Denda
        function confirmCheckOut(nama, kamar, id, denda) {
            let pesan = `Tamu atas nama ${nama} mengembalikan kunci kamar ${kamar}.`;
            let peringatanTambahan = '';

            // Jika ada denda, tampilkan peringatan ekstra di Pop-Up
            if (denda > 0) {
                let dendaFormat = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(denda);
                peringatanTambahan = `<br><br><span style="color: #ef4444; font-weight: bold; font-size: 1.1rem;"><i class="fas fa-exclamation-triangle"></i> TAMU TERKENA DENDA OVERSTAY: ${dendaFormat}</span><br>Pastikan tagihan denda dibayar sebelum tamu pulang!`;
            }

            Swal.fire({
                title: 'Konfirmasi Check-Out',
                html: pesan + peringatanTambahan,
                icon: denda > 0 ? 'error' : 'warning',
                showCancelButton: true,
                background: '#020617', color: '#fff',
                confirmButtonColor: '#e63946', cancelButtonColor: '#334155',
                confirmButtonText: 'Ya, Selesai Check-Out!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/petugas/reservasi/checkout') }}/" + id;
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