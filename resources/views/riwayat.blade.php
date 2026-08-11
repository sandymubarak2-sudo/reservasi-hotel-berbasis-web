<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Sandy Hotel</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --gold: #d4af37;
            --dark: #1a1a1a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4eee0; 
            color: #333;
        }

        .navbar-luxury {
            background-color: var(--dark);
            padding: 15px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            color: var(--gold) !important;
            letter-spacing: 2px;
            font-weight: 700;
        }
        .btn-back {
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }
        .btn-back:hover {
            color: var(--gold);
            transform: translateX(-5px);
        }

        .history-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.06);
            margin-top: 60px;
            margin-bottom: 50px;
            border-top: 5px solid var(--gold);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            color: var(--dark);
            font-weight: 700;
        }

        .total-badge {
            background-color: var(--dark);
            color: var(--gold);
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .table-custom {
            margin-top: 20px;
        }
        .table-custom thead th {
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            padding-bottom: 15px;
        }
        .table-custom tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }
        .table-custom tbody tr:hover {
            background-color: rgba(212, 175, 55, 0.04);
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            border-radius: 10px;
        }
        .table-custom td {
            padding: 25px 15px;
            vertical-align: middle;
            color: #444;
        }

        .room-name {
            font-weight: 600;
            color: var(--dark);
            font-size: 1.1rem;
            font-family: 'Playfair Display', serif;
            letter-spacing: 0.5px;
        }

        .price-text {
            color: #198754;
            font-weight: 700;
            font-size: 1.05rem;
        }

        .status-badge {
            background-color: rgba(212, 175, 55, 0.15);
            color: #b58500;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            border: 1px solid rgba(212, 175, 55, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state i {
            font-size: 4rem;
            color: rgba(212, 175, 55, 0.3);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-luxury sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fs-4 m-0" href="{{ url('/') }}">
                <i class="fas fa-crown me-2"></i>SANDY HOTEL
            </a>
            <a href="{{ url('/') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>

    <div class="container">
        @if(session('sukses'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('sukses') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="history-card mt-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4 pb-4 border-bottom">
                <h2 class="page-title m-0">
                    <i class="fas fa-history text-warning me-2"></i> Riwayat Pesanan Anda
                </h2>
                <div class="total-badge">
                    Total: {{ count($daftarPesanan) }} Pesanan
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Nama Kamar</th>
                            <th><i class="far fa-calendar-alt me-1 text-warning"></i> Check-in</th>
                            <th><i class="far fa-calendar-check me-1 text-warning"></i> Check-out</th>
                            <th>Total Harga</th>
                            <th>Status & Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarPesanan as $pesanan)
                        <tr>
                            <td>
                                <div class="room-name">{{ $pesanan->room->name ?? 'Kamar Tidak Ditemukan' }}</div>
                                <div class="text-muted small mt-1">ID Pesanan: #{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="fw-medium">{{ date('d M Y', strtotime($pesanan->start_date)) }}</td>
                            <td class="fw-medium">{{ date('d M Y', strtotime($pesanan->end_date)) }}</td>
                            
                            <td class="price-text">Rp {{ number_format($pesanan->price, 0, ',', '.') }}</td>
                            
                            <td>
                                @if($pesanan->status == 'Lunas')
                                    <span class="badge bg-success py-2 px-3 d-block text-center mb-2"><i class="fas fa-check-circle"></i> Lunas & Terkonfirmasi</span>
                                    
                                    <a href="{{ url('/cetak-struk/'.$pesanan->id) }}" target="_blank" class="btn btn-outline-dark btn-sm w-100 fw-bold border-2">
                                        <i class="fas fa-print"></i> Cetak Bukti Reservasi
                                    </a>

                                @elseif($pesanan->status == 'Menunggu Verifikasi Admin')
                                    <span class="badge bg-info py-2 px-3 text-dark d-block text-center"><i class="fas fa-spinner fa-spin"></i> Menunggu Verifikasi Admin</span>
                                @else
                                    <span class="status-badge mb-2 d-block text-center"><i class="fas fa-clock"></i> {{ $pesanan->status ?? 'Menunggu Pembayaran' }}</span>
                                    
                                    <form action="{{ url('/bayar/'.$pesanan->id) }}" method="POST" enctype="multipart/form-data" class="mt-2 p-2 border rounded bg-light">
                                        @csrf
                                        <label class="small text-muted fw-bold mb-1">Upload Bukti Transfer:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="file" name="bukti_pembayaran" class="form-control" required accept="image/*">
                                            <button type="submit" class="btn btn-warning fw-bold">Kirim</button>
                                        </div>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h4 class="fw-bold mt-3">Belum Ada Riwayat Pesanan</h4>
                                    <p class="text-muted">Anda belum melakukan reservasi kamar apa pun saat ini.</p>
                                    <a href="{{ url('/') }}#rooms" class="btn btn-dark mt-3 px-4 py-2 text-uppercase fw-bold" style="background-color: var(--gold); border: none; color: #000;">
                                        Pesan Kamar Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="text-center pb-4 text-muted small">
        &copy; 2026 Sandy Hotel - Sistem Reservasi Terintegrasi
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>