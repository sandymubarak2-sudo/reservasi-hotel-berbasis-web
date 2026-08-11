<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - Sandy Hotel</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { 
            --yellow-primary: #d4af37; 
            --dark-bg: #1a1a1a; 
            --card-bg: #222;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #0f0f0f;
            color: #e0e0e0;
        }
        
        h1, h2, h3, h4, .brand-font { font-family: 'Playfair Display', serif; }

        /* Navbar Solid Dark */
        .navbar { background-color: var(--dark-bg); padding: 15px 0; border-bottom: 2px solid var(--yellow-primary); }
        .navbar-brand { color: var(--yellow-primary) !important; letter-spacing: 2px; }

        /* Area Form Kiri */
        .booking-form-card {
            background-color: var(--card-bg); border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 15px; padding: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .form-label { font-weight: 500; color: #ccc; font-size: 0.9rem; }
        .form-control {
            background-color: #2b2b2b; border: 1px solid #444; color: white; padding: 12px 15px; border-radius: 8px;
        }
        .form-control:focus {
            background-color: #2b2b2b; color: white; border-color: var(--yellow-primary); box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }
        .form-control[readonly] { background-color: #1a1a1a; color: #888; cursor: not-allowed; }

        /* Ringkasan Pesanan (Order Summary) Melayang */
        .order-summary-card {
            background: linear-gradient(145deg, #1a1a1a, #222); border: 1px solid var(--yellow-primary);
            border-radius: 15px; padding: 25px; position: sticky; top: 100px;
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.15);
        }
        .summary-img { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 20px; border: 2px solid #333; }
        .summary-title { color: var(--yellow-primary); font-size: 1.4rem; font-weight: bold; border-bottom: 1px dashed #444; padding-bottom: 15px; margin-bottom: 15px; }
        
        .price-details { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; }
        .total-price { display: flex; justify-content: space-between; font-size: 1.3rem; font-weight: bold; color: var(--yellow-primary); border-top: 2px solid #444; padding-top: 15px; margin-top: 15px; }

        /* Tombol Pesan Glow */
        .btn-pesan {
            background-color: var(--yellow-primary); color: black; font-weight: bold; text-transform: uppercase;
            letter-spacing: 1px; padding: 15px; border-radius: 8px; border: none; width: 100%; transition: 0.3s;
        }
        .btn-pesan:hover {
            transform: translateY(-3px); box-shadow: 0 10px 20px rgba(212, 175, 55, 0.4); background-color: #e6c245;
        }

        /* Steps Indicator */
        .step-indicator { display: flex; align-items: center; justify-content: center; margin-bottom: 40px; }
        .step { display: flex; flex-direction: column; align-items: center; color: var(--yellow-primary); }
        .step-icon { width: 40px; height: 40px; border-radius: 50%; background-color: var(--yellow-primary); color: black; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-bottom: 10px; }
        .step-line { width: 80px; height: 3px; background-color: #444; margin: 0 15px; position: relative; top: -15px; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <a class="navbar-brand brand-font fs-3" href="{{ url('/') }}"><i class="fas fa-crown me-2"></i>SANDY HOTEL</a>
        <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm rounded-pill"><i class="fas fa-arrow-left me-1"></i> Batal & Kembali</a>
    </div>
</nav>

<div class="container py-5">
    
    <div class="step-indicator">
        <div class="step">
            <div class="step-icon"><i class="fas fa-check"></i></div>
            <small class="fw-bold">Pilih Kamar</small>
        </div>
        <div class="step-line" style="background-color: var(--yellow-primary);"></div>
        <div class="step">
            <div class="step-icon"><i class="fas fa-pen"></i></div>
            <small class="fw-bold">Isi Detail</small>
        </div>
        <div class="step-line"></div>
        <div class="step" style="color: #666;">
            <div class="step-icon" style="background-color: #444; color: #888;">3</div>
            <small>Pembayaran</small>
        </div>
    </div>

    <div class="row g-5">
        <div class="col-lg-8">
            <div class="booking-form-card">
                <h3 class="brand-font text-white mb-4"><i class="far fa-id-card text-warning me-2"></i> Lengkapi Detail Pemesanan</h3>
                
                <form action="{{ url('/pesan/'.$kamar->id) }}" method="POST" id="bookingForm">
                    @csrf
                    
                    <h5 class="text-warning mb-3 mt-4 border-bottom border-secondary pb-2">Informasi Pemesan</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                            <small class="text-muted fst-italic">*Sesuai akun login</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nomor WhatsApp / HP Aktif <span class="text-danger">*</span></label>
                            <input type="number" name="phone" class="form-control" placeholder="Contoh: 089529900767" required>
                        </div>
                    </div>

                    <h5 class="text-warning mb-3 mt-5 border-bottom border-secondary pb-2">Jadwal Menginap</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Check-In <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Check-Out <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="alert mt-4 mb-0" style="background-color: rgba(212, 175, 55, 0.1); border: 1px solid var(--yellow-primary); color: #ccc;">
                        <i class="fas fa-info-circle text-warning me-2"></i> <strong>Kebijakan Hotel:</strong> Waktu Check-In dimulai dari pukul 14:00 WIB, dan waktu Check-Out maksimal pukul 12:00 WIB siang.
                    </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="order-summary-card">
                @php
                    $img = 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=500';
                    if($kamar->type == 'Two') $img = 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=500';
                    if($kamar->type == 'Studio') $img = 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500';
                @endphp
                <img src="{{ $img }}" class="summary-img" alt="{{ $kamar->name }}">
                
                <h4 class="summary-title">{{ $kamar->name }}</h4>
                
                <div class="text-light mb-4">
                    <div class="mb-2"><i class="fas fa-bed text-muted me-2"></i> Tipe: <strong>{{ $kamar->type }} Bed</strong></div>
                    <div class="mb-2"><i class="fas fa-door-open text-muted me-2"></i> Nomor: <strong>KM-{{ $kamar->number }}</strong></div>
                </div>

                <div class="price-details text-muted">
                    <span>Harga per Malam</span>
                    <span class="text-light" id="base_price" data-price="{{ $kamar->price }}">Rp {{ number_format($kamar->price, 0, ',', '.') }}</span>
                </div>
                <div class="price-details text-muted">
                    <span>Durasi Inap</span>
                    <span class="text-warning fw-bold" id="duration_display">0 Malam</span>
                </div>

                <div class="total-price">
                    <span>Total Pembayaran</span>
                    <span id="total_display">Rp 0</span>
                </div>

                <button type="submit" class="btn-pesan mt-4" form="bookingForm">
                    <i class="fas fa-lock me-2"></i> Konfirmasi Pesanan
                </button>
                <div class="text-center mt-3">
                    <small class="text-muted"><i class="fas fa-shield-alt text-success me-1"></i> Transaksi Anda 100% Aman</small>
                </div>
                </form> </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Mencegah input tanggal di masa lalu (Min Date = Hari Ini)
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("start_date").setAttribute('min', today);
    document.getElementById("end_date").setAttribute('min', today);

    // 2. Kalkulator Harga Otomatis Pintar
    const pricePerNight = parseInt(document.getElementById('base_price').getAttribute('data-price'));
    const startInput = document.getElementById('start_date');
    const endInput = document.getElementById('end_date');
    const durationDisplay = document.getElementById('duration_display');
    const totalDisplay = document.getElementById('total_display');

    function calculateTotal() {
        const startDate = new Date(startInput.value);
        const endDate = new Date(endInput.value);

        if (startInput.value && endInput.value) {
            // Mencegah tanggal Check-out lebih kecil dari Check-in
            if (endDate <= startDate) {
                Swal.fire({
                    icon: 'error', title: 'Tanggal Tidak Valid!',
                    text: 'Tanggal Check-out harus setelah tanggal Check-in.',
                    background: '#1a1a1a', color: '#fff', confirmButtonColor: '#d4af37'
                });
                endInput.value = ''; // Reset input end date
                durationDisplay.innerText = '0 Malam';
                totalDisplay.innerText = 'Rp 0';
                return;
            }

            // Menghitung selisih hari
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const totalPrice = diffDays * pricePerNight;

            // Update UI Ringkasan Pesanan
            durationDisplay.innerText = diffDays + ' Malam';
            totalDisplay.innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
        }
    }

    // Pasang alat pendeteksi perubahan pada kolom tanggal
    startInput.addEventListener('change', calculateTotal);
    endInput.addEventListener('change', calculateTotal);
</script>

</body>
</html>