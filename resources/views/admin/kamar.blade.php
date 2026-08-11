<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kamar - Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            /* TEMA BIRU & MERAH (ROYAL NAVY & VELVET RED) */
            --primary: #e63946; /* Merah Velvet */
            --dark-bg: #020617; /* Navy Gelap */
            --card-bg: #0f172a; /* Navy untuk Card */
            --text-light: #e0e0e0;
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
            border-right: 1px solid rgba(230, 57, 70, 0.2);
            padding-top: 20px;
            z-index: 1000;
        }
        .sidebar-brand {
            font-size: 1.5rem; font-weight: 700; color: var(--primary);
            text-align: center; margin-bottom: 30px; letter-spacing: 2px;
        }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li { margin-bottom: 10px; }
        .sidebar-menu a {
            display: block; padding: 15px 25px; color: #a0a0a0; text-decoration: none;
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
            margin-bottom: 30px; border: 1px solid rgba(255,255,255,0.05);
        }

        /* Panel Area */
        .panel-card {
            background-color: var(--card-bg); border-radius: 15px; padding: 25px;
            border: 1px solid rgba(255,255,255,0.05); margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .panel-title { font-weight: 600; color: var(--primary); margin-bottom: 20px; font-size: 1.2rem; }

        /* Customizing DataTables for Dark Mode */
        .table { color: var(--text-light); }
        .table thead { background-color: rgba(230, 57, 70, 0.1); color: var(--primary); border-bottom: 2px solid var(--primary); }
        .table-striped>tbody>tr:nth-of-type(odd)>* { color: var(--text-light); }
        .table-hover>tbody>tr:hover>* { background-color: rgba(255, 255, 255, 0.05); color: white; }
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, 
        .dataTables_wrapper .dataTables_paginate { color: #a0a0a0; margin-bottom: 15px; }
        .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: white; }
        .page-link { background-color: #1e293b; border-color: #334155; color: #a0a0a0; }
        .page-link:hover { background-color: var(--primary); color: white; }
        .form-control, .form-select { background-color: #1e293b; border: 1px solid #334155; color: white; }
        .form-control:focus, .form-select:focus { background-color: #1e293b; color: white; border-color: var(--primary); box-shadow: none; }
        
        /* Action Buttons */
        .btn-action { width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: 0.3s; margin: 0 2px; }
        .btn-edit { background-color: rgba(13, 110, 253, 0.2); color: #0d6efd; }
        .btn-edit:hover { background-color: #0d6efd; color: white; }
        .btn-delete { background-color: rgba(230, 57, 70, 0.2); color: var(--primary); }
        .btn-delete:hover { background-color: var(--primary); color: white; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand"><i class="fas fa-crown"></i> SANDY HOTEL</div>
        <ul class="sidebar-menu">
            <li><a href="{{ url('/admin') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="{{ url('/admin/reservasi') }}"><i class="fas fa-calendar-check me-2"></i> Data Reservasi</a></li>
            <li><a href="{{ url('/admin/kamar') }}" class="active"><i class="fas fa-bed me-2"></i> Manajemen Kamar</a></li>
            <li><a href="{{ url('/admin/tamu') }}"><i class="fas fa-users me-2"></i> Daftar Tamu</a></li>
            <li><a href="{{ url('/admin/keuangan') }}"><i class="fas fa-wallet me-2"></i> Laporan Keuangan</a></li>
            <li><a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-2"></i> Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="topbar">
            <div>
                <h4 class="mb-0 fw-bold">Manajemen Kamar</h4>
                <small class="text-muted">Kelola data kamar hotel, tipe, dan harga.</small>
            </div>
            <div>
                <span class="me-3 fw-bold" style="color: var(--primary);"><i class="fas fa-user-shield"></i> {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-light mb-0"><i class="fas fa-list me-2"></i> Daftar Seluruh Kamar</h5>
            <a href="{{ url('/admin/kamar/tambah') }}" class="btn fw-bold px-4 rounded-pill" style="background-color: var(--primary); color: white;">
                <i class="fas fa-plus-circle me-2"></i> Tambah Kamar Baru
            </a>
        </div>

        <div class="panel-card">
            <div class="table-responsive">
                <table id="smartTable" class="table table-hover table-striped align-middle text-center">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-start">Nama Kamar</th>
                            <th>No. Kamar</th>
                            <th>Tipe / Bed</th>
                            <th>Harga per Malam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarKamar as $index => $kamar)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-start fw-bold text-light">{{ $kamar->name }}</td>
                            <td><span class="badge bg-secondary">KM-{{ $kamar->number }}</span></td>
                            <td>
                                @if($kamar->type == 'Studio')
                                    <span class="text-info"><i class="fas fa-bed me-1"></i> Studio</span>
                                @elseif($kamar->type == 'Two')
                                    <span class="text-warning"><i class="fas fa-bed me-1"></i> Two Bed</span>
                                @else
                                    <span class="text-light"><i class="fas fa-bed me-1"></i> {{ $kamar->type }}</span>
                                @endif
                            </td>
                            <td class="fw-bold" style="color: var(--primary);">Rp {{ number_format($kamar->price, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ url('/admin/kamar/edit/'.$kamar->id) }}" class="btn-action btn-edit" title="Edit Kamar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn-action btn-delete" title="Hapus Kamar" onclick="confirmDelete({{ $kamar->id }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data kamar yang ditambahkan.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Inisialisasi DataTables
        $(document).ready(function() {
            $('#smartTable').DataTable({
                "language": {
                    "search": "Cari Kamar:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ kamar",
                    "paginate": {
                        "first": "Awal",
                        "last": "Akhir",
                        "next": "<i class='fas fa-chevron-right'></i>",
                        "previous": "<i class='fas fa-chevron-left'></i>"
                    }
                }
            });
        });

        // SweetAlert untuk Notifikasi Sukses
        @if(session('sukses'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('sukses') }}',
                background: '#0f172a',
                color: '#fff',
                confirmButtonColor: '#e63946'
            });
        @endif

        // Konfirmasi Hapus Kamar dengan SweetAlert
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Kamar yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                background: '#0f172a',
                color: '#fff',
                confirmButtonColor: '#e63946',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/admin/kamar/hapus') }}/" + id;
                }
            })
        }
    </script>
</body>
</html>