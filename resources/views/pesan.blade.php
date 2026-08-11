<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Kamar - Sandy Hotel</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { 
            --yellow-primary: #d4af37; 
            --dark-bg: #1a1a1a; 
            --champagne-light: #fdfbf7;
            --champagne-dark: #e8dec8;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: radial-gradient(circle at top, var(--champagne-light) 0%, #f4eee0 40%, var(--champagne-dark) 100%);
            min-height: 100vh;
        }
        
        h1, h2, h3, h4, h5, .navbar-brand { font-family: 'Playfair Display', serif; }

        /* Navbar */
        .navbar { background-color: var(--dark-bg) !important; padding: 15px 0; }
        .navbar-brand { color: var(--yellow-primary) !important; letter-spacing: 2px; }
        .nav-link { color: #fff !important; font-weight: 300; letter-spacing: 1px; transition: 0.3s; }

        /* Header Pemesanan */
        .booking-header {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            padding: 80px 0 50px;
            color: white;
            text-align: center;
            border-bottom: 5px solid var(--yellow-primary);
        }

        /* Form Card */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .form-label { font-weight: 600; color: var(--dark-bg); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
        .form-control, .form-select {
            padding: 12px 15px; border-radius: 8px; border: 1px solid #ddd; background-color: #f9f9f9;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.2); border-color: var(--yellow-primary); background-color: #fff;
        }

        /* Summary Card (Kanan) */
        .summary-card {
            background-color: var(--dark-bg);
            color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            position: sticky;
            top: 100px; /* Membuatnya melayang saat discroll */
            border: 1px solid #333;
        }
        .summary-img { width: 100%; height: 200px; object-fit: cover; }
        .summary-body { padding: 30px; }
        .summary-title { color: var(--yellow-primary); font-family: 'Playfair Display', serif; }
        
        .price-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.95rem; color: #ccc; }
        .price-total { 
            display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; 
            border-top: 1px dashed rgba(255,255,255,0.2); font-size: 1.3rem; font-weight: 700; color: white;
        }

        .btn-confirm {
            background-color: var(--yellow-primary); color: #000; font-weight: 700;
            padding: 15px; border-radius: 8px; letter-spacing: 1px; text-transform: uppercase;
            transition: 0.3s; width: 100%; border: none; margin-top: 20px;
        }
        .btn-confirm:hover { background-color: #bfa030; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3); }

        /* Footer */
        .footer-premium { background-color: #161412; color: #a0a0a0; border-top: 3px solid var(--yellow-primary); }
        .footer-title { color: #ffffff; font-weight: 500; font-size: 1.1rem; }
        .footer-links { padding-left: 0; list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: #a0a0a0; text-decoration: none; transition: 0.3s; display: flex; align-items: center; }
        .footer-links a:hover { color: var(--yellow-primary); transform: translateX(5px); }
        .footer-icon-wrapper { width: 25px; color: #ffffff; }
        .footer-links a:hover .footer-icon-wrapper { color: var(--yellow-primary); }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top shadow-lg">
    <div class="container">
        <a class="navbar-brand fs-3" href="{{ url('/') }}"><i class="fas fa-crown me-2"></i>SANDY HOTEL</a>
        <div class="ms-auto d-none d-lg-block">
            <span class="text-white small opacity-75"><i class="fas fa-lock me-1"></i> Pembayaran Aman & Terenkripsi</span>
        </div>
    </div>
</nav>

<!-- Header -->
<div class="booking-header mb-5">
    <div class="container">
        <h2 class="display-5 fw-bold mb-2">Selesaikan Reservasi Anda</h2>
        <p class="lead fw-light">Hanya butuh beberapa langkah untuk pengalaman menginap tak terlupakan.</p>
    </div>
</div>

<div class="container pb-5 mb-5">
    <form action="{{ url('/pesan/'.$kamar->id) }}" method="POST">
        @csrf
        <div class="row g-5">
            
            <!-- KIRI: Form Pengisian Data -->
            <div class="col-lg-7">
                <div class="form-card mb-4">
                    <h4 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--dark-bg);">
                        <i class="far fa-id-card text-warning me-2"></i> Data Tamu
                    </h4>
                    
                    <div class="row g-3">
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Nama Lengkap</label>
                            <!-- Otomatis mengambil nama yang sedang login -->
                            <input type="text" class="form-control bg-light" value="{{ Auth::check() ? Auth::user()->name : '' }}" readonly>
                            <small class="text-muted fst-italic">Nama tamu disesuaikan dengan akun login Anda.</small>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <h4 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--dark-bg);">
                        <i class="far fa-calendar-alt text-warning me-2"></i> Rincian Menginap
                    </h4>
                    
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Check-in</label>
                            <input type="date" name="check_in" id="checkIn" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Check-out</label>
                            <input type="date" name="check_out" id="checkOut" class="form-control" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Permintaan Khusus (Opsional)</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Contoh: Minta kamar di lantai atas, alergi makanan, dll."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KANAN: Ringkasan Pesanan -->
            <div class="col-lg-5">
                <div class="summary-card">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="summary-img" alt="Kamar">
                    
                    <div class="summary-body">
                        <span class="badge bg-warning text-dark px-3 py-2 text-uppercase fw-bold mb-3">{{ $kamar->type }} Room</span>
                        <h3 class="summary-title mb-1">{{ $kamar->name }}</h3>
                        <p class="text-muted small mb-4"><i class="fas fa-door-closed me-1"></i> Kamar Nomor: {{ $kamar->number }}</p>

                        <h5 class="fw-bold mb-3 border-bottom border-secondary pb-2">Rincian Harga</h5>
                        
                        <div class="price-row">
                            <span>Harga Per Malam</span>
                            <span id="hargaPerMalam" data-harga="{{ $kamar->price }}">Rp {{ number_format($kamar->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="price-row">
                            <span>Durasi Menginap</span>
                            <span id="durasiMalam">0 Malam</span>
                        </div>
                        <div class="price-row">
                            <span>Pajak & Layanan (10%)</span>
                            <span id="pajakLayanan">Rp 0</span>
                        </div>

                        <div class="price-total">
                            <span>Total Pembayaran</span>
                            <span id="totalHarga" class="text-warning">Rp 0</span>
                        </div>

                        <button type="submit" class="btn btn-confirm mt-4">
                            Konfirmasi Pesanan <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        
                        <p class="text-center small text-muted mt-3 mb-0">
                            <i class="fas fa-info-circle me-1"></i> Anda tidak akan dikenakan biaya saat ini.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- Footer Premium -->
<footer class="footer-premium py-5 mt-5">
    <div class="container">
        <div class="row gx-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title mb-4">About Us</h5>
                <ul class="footer-links">
                    <li><a href="#">Company</a></li>
                    <li><a href="#">Business Service</a></li>
                    <li><a href="#">Our Location</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title mb-4">Social Media</h5>
                <ul class="footer-links">
                    <li><a href="https://facebook.com/sandy mubarak" target="_blank"><span class="footer-icon-wrapper"><i class="fab fa-facebook fs-5"></i></span> Facebook</a></li>
                    <li><a href="https://instagram.com/sndy_m" target="_blank"><span class="footer-icon-wrapper"><i class="fab fa-instagram fs-5"></i></span> Instagram</a></li>
                    <li><a href="https://wa.me/6289529900767" target="_blank"><span class="footer-icon-wrapper"><i class="fab fa-whatsapp fs-5"></i></span> WhatsApp</a></li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <h5 class="footer-title mb-4">Address & Contact</h5>
                <p class="small mb-2" style="color: #a0a0a0;">Gedung Teknik Informatika<br>Universitas Negeri Padang<br>Kota Padang, Sumatera Barat 25171</p>
                <div class="d-flex text-white mt-3">
                    <span class="me-4"><i class="fas fa-phone-alt text-warning me-2"></i> +62 895-2990-0767</span>
                    <span><i class="far fa-envelope text-warning me-2"></i> info@sandyhotel.com</span>
                </div>
            </div>
        </div>
        <div class="border-top border-secondary border-opacity-25 mt-4 pt-4 text-center">
            <p class="small text-muted mb-0">&copy; 2026 Sandy Mubarak - Sistem Informasi Hotel</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Skrip Kalkulasi Harga Otomatis Berdasarkan Tanggal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkInInput = document.getElementById('checkIn');
        const checkOutInput = document.getElementById('checkOut');
        
        // Atur agar tanggal minimal Check-in adalah hari ini
        let today = new Date().toISOString().split('T')[0];
        checkInInput.setAttribute('min', today);
        checkOutInput.setAttribute('min', today);

        function calculateTotal() {
            const checkInDate = new Date(checkInInput.value);
            const checkOutDate = new Date(checkOutInput.value);
            
            // Pastikan Check-out harus setelah Check-in
            if(checkInInput.value) {
                let nextDay = new Date(checkInDate);
                nextDay.setDate(nextDay.getDate() + 1);
                checkOutInput.setAttribute('min', nextDay.toISOString().split('T')[0]);
            }

            if(checkInDate && checkOutDate && checkOutDate > checkInDate) {
                // Hitung selisih hari
                const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
                const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                const hargaPerMalam = parseInt(document.getElementById('hargaPerMalam').getAttribute('data-harga'));
                const subTotal = hargaPerMalam * daysDiff;
                const pajak = subTotal * 0.10; // Pajak 10%
                const totalFinal = subTotal + pajak;

                // Update UI di layar
                document.getElementById('durasiMalam').innerText = daysDiff + " Malam";
                document.getElementById('pajakLayanan').innerText = "Rp " + pajak.toLocaleString('id-ID');
                document.getElementById('totalHarga').innerText = "Rp " + totalFinal.toLocaleString('id-ID');
            } else {
                document.getElementById('durasiMalam').innerText = "0 Malam";
                document.getElementById('pajakLayanan').innerText = "Rp 0";
                document.getElementById('totalHarga').innerText = "Rp 0";
            }
        }

        checkInInput.addEventListener('change', calculateTotal);
        checkOutInput.addEventListener('change', calculateTotal);
    });
</script>

</body>
</html>