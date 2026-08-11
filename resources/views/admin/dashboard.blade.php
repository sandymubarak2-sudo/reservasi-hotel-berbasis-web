<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sandy Hotel</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
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
            --card-bg-alt: #16213a;
            --border-soft: rgba(230, 57, 70, 0.25);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --radius: 16px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            background-image: radial-gradient(circle at top right, rgba(230,57,70,0.08), transparent 45%);
            color: var(--text-light);
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 260px; height: 100vh;
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-soft);
            padding-top: 20px;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 800; color: var(--primary);
            text-align: center; margin-bottom: 30px; letter-spacing: 2px;
            padding-bottom: 20px; border-bottom: 1px solid var(--border-soft);
        }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li { margin-bottom: 6px; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 10px;
            padding: 14px 25px; color: var(--text-muted); text-decoration: none;
            transition: 0.25s; font-weight: 500; border-left: 4px solid transparent;
        }
        .sidebar-menu a i { width: 20px; text-align: center; }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            color: var(--primary); background: rgba(230, 57, 70, 0.1); border-left-color: var(--primary);
        }

        /* Mobile toggle */
        .sidebar-toggle {
            display: none;
            position: fixed; top: 15px; left: 15px; z-index: 1100;
            background: var(--primary); color: #fff; border: none;
            width: 44px; height: 44px; border-radius: 12px; font-size: 1.1rem;
            box-shadow: 0 6px 16px rgba(230,57,70,0.4);
        }
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 999;
        }
        .sidebar-overlay.show { display: block; }

        /* Main Content */
        .main-content {
            margin-left: 260px; padding: 30px; min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Top Navbar */
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: var(--card-bg); padding: 18px 30px; border-radius: var(--radius);
            margin-bottom: 30px; border: 1px solid var(--border-soft);
            flex-wrap: wrap; gap: 12px;
        }
        .topbar h4 { font-family: 'Playfair Display', serif; }
        .admin-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(230,57,70,0.1); border: 1px solid var(--border-soft);
            color: var(--primary); padding: 8px 16px; border-radius: 999px; font-weight: 600;
        }

        /* Gradient Cards */
        .stat-card {
            border-radius: var(--radius); padding: 25px; position: relative; overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.35); color: white; border: none;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            height: 100%;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 36px rgba(0,0,0,0.5);
        }
        .card-red { background: linear-gradient(135deg, #e63946 0%, #900b16 100%); }
        .card-dark { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid var(--border-soft); }
        .card-blue { background: linear-gradient(135deg, #334155 0%, #0f172a 100%); border: 1px solid rgba(255,255,255,0.1); }

        .stat-icon {
            position: absolute; right: -10px; bottom: -20px; font-size: 8rem;
            opacity: 0.15; transform: rotate(-15deg);
        }
        .stat-label {
            font-size: 0.78rem; letter-spacing: 1.5px; margin-bottom: 8px;
        }
        .stat-value { font-family: 'Playfair Display', serif; font-weight: 800; }

        /* Chart & Table Area */
        .panel-card {
            background-color: var(--card-bg); border-radius: var(--radius); padding: 25px;
            border: 1px solid var(--border-soft); margin-bottom: 30px;
        }
        .panel-title {
            font-weight: 600; color: var(--primary); margin-bottom: 20px; font-size: 1.2rem;
            display: flex; align-items: center; gap: 10px;
        }

        /* DataTables Dark Navy */
        .table { color: var(--text-light); margin-bottom: 0; }
        .table thead th {
            background-color: rgba(230, 57, 70, 0.1); color: var(--primary);
            border-bottom: 2px solid var(--primary); white-space: nowrap;
        }
        .table-striped>tbody>tr:nth-of-type(odd)>* { color: var(--text-light); background-color: var(--card-bg-alt); }
        .table-hover>tbody>tr:hover>* { background-color: rgba(230, 57, 70, 0.08); color: white; }
        .table > :not(caption) > * > * { border-bottom-color: rgba(255,255,255,0.06); }

        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate { color: var(--text-muted); margin-top: 12px; }

        .page-item .page-link { background-color: var(--card-bg); border-color: var(--border-soft); color: var(--text-muted); }
        .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: #ffffff; font-weight: 600; }
        .page-item.disabled .page-link { background-color: var(--dark-bg); border-color: var(--border-soft); color: #475569; }

        .form-control, .form-select { background-color: var(--dark-bg); border: 1px solid rgba(255,255,255,0.2); color: var(--text-light); }
        .form-control:focus, .form-select:focus { background-color: var(--dark-bg); color: white; border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.25); }
        .form-control::placeholder { color: #64748b; }

        /* Empty state */
        .empty-state { text-align: center; padding: 50px 20px; color: var(--text-muted); }
        .empty-state i { font-size: 2.6rem; color: var(--primary); opacity: 0.5; margin-bottom: 12px; display: block; }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 75px 16px 20px; }
            .sidebar-toggle { display: block; }
        }
    </style>
</head>
<body>

    <button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand"><i class="fas fa-crown"></i> SANDY HOTEL</div>
        <ul class="sidebar-menu">
            <li><a href="{{ url('/admin') }}" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ url('/admin/reservasi') }}"><i class="fas fa-calendar-check"></i> Data Reservasi</a></li>
            <li><a href="{{ url('/admin/kamar') }}"><i class="fas fa-bed"></i> Manajemen Kamar</a></li>
            <li><a href="{{ url('/admin/tamu') }}"><i class="fas fa-users"></i> Daftar Tamu</a></li>
            <li><a href="{{ url('/admin/keuangan') }}"><i class="fas fa-wallet"></i> Laporan Keuangan</a></li>
            <li><a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe"></i> Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">

        <div class="topbar">
            <div>
                <h4 class="mb-0 fw-bold">Selamat Datang, Admin!</h4>
                <small class="text-muted">Pantau dan kelola aktivitas hotel hari ini.</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="admin-badge"><i class="fas fa-user-shield"></i> {{ Auth::user()->name ?? 'Admin' }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card card-red">
                    <i class="fas fa-wallet stat-icon"></i>
                    <p class="mb-1 fw-semibold text-white text-uppercase stat-label">Total Pendapatan</p>
                    <h2 class="mb-0 text-white stat-value">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card-dark">
                    <i class="fas fa-calendar-check stat-icon"></i>
                    <p class="mb-1 fw-semibold text-uppercase stat-label" style="color: var(--text-muted);">Total Pesanan</p>
                    <h2 class="mb-0 stat-value" style="color: var(--primary);">{{ $totalPesanan ?? 0 }} <small class="fs-6 text-muted fw-normal">Reservasi</small></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card-blue">
                    <i class="fas fa-door-open stat-icon"></i>
                    <p class="mb-1 fw-semibold text-white text-uppercase stat-label">Jumlah Kamar</p>
                    <h2 class="mb-0 text-white stat-value">{{ $totalKamar ?? 0 }} <small class="fs-6 text-white-50 fw-normal">Unit</small></h2>
                </div>
            </div>
        </div>

        <div class="panel-card">
            <h5 class="panel-title"><i class="fas fa-chart-line"></i> Tren Pemesanan (7 Hari Terakhir)</h5>
            <div style="height: 350px; width: 100%;">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>

        <div class="panel-card">
            <h5 class="panel-title"><i class="fas fa-list"></i> Data Reservasi Terbaru</h5>
            <div class="table-responsive">
                <table id="smartTable" class="table table-hover table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tamu</th>
                            <th>Tipe Kamar</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $item->customer->name ?? 'Tamu Dihapus' }}</td>
                            <td>{{ $item->room->name ?? 'Kamar Dihapus' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}</td>
                            <td class="fw-bold" style="color: var(--primary);">Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status == 'Lunas')
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Lunas</span>
                                @elseif($item->status == 'Menunggu Pembayaran')
                                    <span class="badge bg-danger"><i class="fas fa-clock"></i> Menunggu Bayar</span>
                                @elseif($item->status == 'Menunggu Verifikasi Admin')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-spinner fa-spin"></i> Verifikasi</span>
                                @else
                                    <span class="badge" style="background-color: var(--border-soft);">{{ $item->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open"></i>
                                    Belum ada data reservasi.
                                </div>
                            </td>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function () {

            // Sidebar toggle (mobile)
            $('#sidebarToggle, #sidebarOverlay').on('click', function () {
                $('#sidebar').toggleClass('show');
                $('#sidebarOverlay').toggleClass('show');
            });

            // Init DataTables
            if ($('#smartTable tbody tr').length && !$('#smartTable tbody').find('.empty-state').length) {
                $('#smartTable').DataTable({
                    "language": {
                        "search": "Cari Tamu:",
                        "lengthMenu": "Tampilkan _MENU_ data",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ reservasi",
                        "infoEmpty": "Tidak ada data tersedia",
                        "emptyTable": "Belum ada data reservasi.",
                        "paginate": {
                            "first": "Awal",
                            "last": "Akhir",
                            "next": "Lanjut",
                            "previous": "Mundur"
                        }
                    }
                });
            }

            // CONFIG CHART.JS LEVEL DEWA
            const chartEl = document.getElementById('bookingChart');
            if (chartEl) {
                const ctx = chartEl.getContext('2d');

                const labels = {!! json_encode($labels ?? []) !!};
                const dataPoint = {!! json_encode($totals ?? []) !!};

                let gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(230, 57, 70, 0.5)'); // Velvet Red transparan
                gradient.addColorStop(1, 'rgba(230, 57, 70, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pemesanan Baru',
                            data: dataPoint,
                            borderColor: '#e63946', // Velvet Red
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#0f172a', // Dark Navy
                            pointBorderColor: '#e63946',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            fill: true,
                            tension: 0.4 // Membuat garis melengkung (smooth curve)
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false // Sembunyikan legenda default biar elegan
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleColor: '#e63946',
                                bodyColor: '#f8fafc',
                                borderColor: 'rgba(230, 57, 70, 0.25)',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Total: ' + context.parsed.y + ' Pesanan Kamar';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#94a3b8'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    stepSize: 1 // Angka di sumbu Y tidak akan berkoma
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>