<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Reservasi - Petugas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --gold-primary: #d4af37; --dark-bg: #1a1a1a; --sidebar-bg: #111111; --bg-light: #f4f6f9; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-light); overflow-x: hidden; }
        .sidebar { background-color: var(--sidebar-bg); color: #fff; min-height: 100vh; width: 260px; position: fixed; top: 0; left: 0; padding-top: 20px; z-index: 1000; }
        .sidebar-brand { font-size: 1.2rem; font-weight: 700; color: #fff; text-align: center; margin-bottom: 30px; letter-spacing: 1px; }
        .sidebar-brand span { color: var(--gold-primary); }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li { padding: 12px 25px; transition: 0.3s; }
        .sidebar-menu a { color: #a0a0a0; text-decoration: none; display: flex; align-items: center; }
        .sidebar-menu li.active { background-color: rgba(212, 175, 55, 0.1); border-left: 4px solid var(--gold-primary); }
        .sidebar-menu li.active a { color: var(--gold-primary); }
        .main-content { margin-left: 260px; padding: 0; }
        .topbar { background: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .table-wrapper { background: #fff; border-radius: 12px; padding: 25px; margin: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-brand"><i class="fas fa-concierge-bell me-2"></i> PANEL <span>PETUGAS</span></div>
    <ul class="sidebar-menu">
        <li><a href="{{ url('/petugas') }}"><i class="fas fa-th-large me-2"></i> Dashboard</a></li>
        <li class="active"><a href="{{ url('/petugas/reservasi') }}"><i class="fas fa-calendar-check me-2"></i> Data Reservasi</a></li>
        <hr class="border-secondary mx-3">
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-transparent border-0 text-muted ps-4"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
            </form>
        </li>
    </ul>
</div>

<div class="main-content">
    <div class="topbar">
        <h4 class="m-0 fw-bold">Data Reservasi Tamu</h4>
    </div>
    
    <div class="table-wrapper">
        @if(session('sukses'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('sukses') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tamu</th>
                    <th>Kamar</th>
                    <th>Check-in / Out</th>
                    <th>Total Biaya</th>
                    <th>Status & Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarPesanan as $pesanan)
                <tr>
                    <td>
                        <span class="fw-bold">{{ $pesanan->customer->name ?? 'N/A' }}</span><br>
                        <small class="text-muted"><i class="fab fa-whatsapp text-success"></i> {{ $pesanan->customer->phone ?? '-' }}</small>
                    </td>
                    <td>
                        <span class="fw-semibold text-dark">{{ $pesanan->room->name ?? 'N/A' }}</span><br>
                        <small class="text-muted">ID: #{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}</small>
                    </td>
                    <td>
                        <small class="d-block"><i class="far fa-calendar-alt text-warning"></i> In: {{ date('d M Y', strtotime($pesanan->start_date)) }}</small>
                        <small class="d-block"><i class="far fa-calendar-check text-warning"></i> Out: {{ date('d M Y', strtotime($pesanan->end_date)) }}</small>
                    </td>
                    <td class="fw-bold text-success">Rp {{ number_format($pesanan->price, 0, ',', '.') }}</td>
                    
                    <td>
                        @if($pesanan->status == 'Selesai')
                            <span class="badge bg-secondary mb-1"><i class="fas fa-check-circle"></i> Selesai</span>
                        @elseif($pesanan->status == 'Sedang Menginap')
                            <span class="badge bg-primary mb-1"><i class="fas fa-bed"></i> Sedang Menginap</span>
                        @elseif($pesanan->status == 'Lunas')
                            <span class="badge bg-success mb-1"><i class="fas fa-check-double"></i> Lunas</span>
                        @elseif($pesanan->status == 'Menunggu Verifikasi Admin')
                            <span class="badge bg-info text-dark mb-1"><i class="fas fa-spinner fa-spin"></i> Menunggu Verifikasi</span>
                        @else
                            <span class="badge bg-warning text-dark mb-1"><i class="fas fa-clock"></i> {{ $pesanan->status ?? 'Menunggu Pembayaran' }}</span>
                        @endif

                        <div class="mt-2 d-flex gap-1 flex-wrap">
                            
                            {{-- Tombol Verifikasi (Jika tamu sudah kirim struk) --}}
                            @if($pesanan->bukti_pembayaran && $pesanan->status == 'Menunggu Verifikasi Admin')
                                <a href="{{ asset($pesanan->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat Struk">
                                    <i class="fas fa-file-invoice-dollar"></i> Cek Struk
                                </a>
                                <a href="{{ url('/petugas/reservasi/lunas/'.$pesanan->id) }}" class="btn btn-sm btn-success" onclick="return confirm('Apakah pembayaran sudah valid dan ingin diverifikasi?')">
                                    <i class="fas fa-check"></i> Verifikasi
                                </a>
                            
                            {{-- Tombol Check-In (Jika tamu sudah Lunas dan datang ke hotel) --}}
                            @elseif($pesanan->status == 'Lunas')
                                <a href="{{ url('/petugas/reservasi/checkin/'.$pesanan->id) }}" class="btn btn-sm btn-primary w-100 fw-bold" onclick="return confirm('Apakah tamu sudah tiba dan ingin Check-In sekarang?')">
                                    <i class="fas fa-key"></i> Proses Check-In
                                </a>

                            {{-- Tombol Check-Out (Jika tamu sedang menginap dan ingin pulang) --}}
                            @elseif($pesanan->status == 'Sedang Menginap')
                                <a href="{{ url('/petugas/reservasi/checkout/'.$pesanan->id) }}" class="btn btn-sm btn-danger w-100 fw-bold" onclick="return confirm('Apakah tamu ingin Check-Out sekarang?')">
                                    <i class="fas fa-sign-out-alt"></i> Proses Check-Out
                                </a>
                            @endif

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>