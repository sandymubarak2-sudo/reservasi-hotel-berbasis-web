<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandy Hotel - Luxury & Comfort</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ====== DESIGN TOKENS ====== */
        :root {
            --red-primary: #e63946;
            --red-soft: rgba(230, 57, 70, 0.18);
            --deep-blue: #020617;
            --card-blue: #0f172a;
            --card-blue-light: #16213d;
            --border-soft: rgba(230, 57, 70, 0.16);
            --border-mid: rgba(230, 57, 70, 0.3);
            --text-light: #f1f5f9;
            --text-muted: #94a3b8;
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--deep-blue);
            background-image:
                radial-gradient(circle at 15% 0%, rgba(230,57,70,0.07) 0%, transparent 45%),
                radial-gradient(circle at 85% 20%, rgba(15,23,42,0.9) 0%, transparent 50%);
            color: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .navbar-brand { font-family: 'Playfair Display', serif; }

        /* ====== PRELOADER ====== */
        #luxury-preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: var(--deep-blue); z-index: 999999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: opacity 1s ease, visibility 1s ease;
        }
        .preloader-icon {
            font-size: 4.5rem; color: var(--red-primary);
            animation: pulse-crown 2s infinite alternate; margin-bottom: 22px;
        }
        .preloader-text {
            font-family: 'Playfair Display', serif; color: var(--text-light);
            letter-spacing: 8px; font-size: 1.6rem; font-weight: 700; margin-bottom: 28px;
        }
        .loading-bar {
            width: 160px; height: 2px; background: rgba(255,255,255,0.06);
            border-radius: 10px; overflow: hidden; position: relative;
        }
        .loading-bar::after {
            content: ''; position: absolute; left: -60px; top: 0;
            width: 60px; height: 100%;
            background: linear-gradient(90deg, transparent, var(--red-primary), transparent);
            animation: loading-slide 1.6s infinite ease-in-out;
        }
        @keyframes pulse-crown {
            0% { transform: scale(1); opacity: 0.7; }
            100% { transform: scale(1.12); opacity: 1; text-shadow: 0 0 30px rgba(230,57,70,0.55); }
        }
        @keyframes loading-slide { 0% { left: -60px; } 100% { left: 160px; } }
        .preloader-hidden { opacity: 0; visibility: hidden; }

        /* ====== NAVBAR ====== */
        .navbar {
            padding: 26px 0; transition: all 0.4s ease;
            position: fixed; width: 100%; top: 0; z-index: 1030;
        }
        .navbar-scrolled {
            background-color: rgba(2, 6, 23, 0.97) !important;
            backdrop-filter: blur(14px);
            padding: 14px 0;
            border-bottom: 1px solid var(--border-soft);
        }
        .navbar-brand {
            color: var(--red-primary) !important;
            letter-spacing: 3px; font-weight: 800;
        }
        .nav-link {
            color: #cbd5e1 !important; font-weight: 300;
            letter-spacing: 1.5px; transition: color 0.3s; font-size: 0.92rem;
        }
        .nav-link:hover { color: var(--red-primary) !important; }

        /* ====== HERO ====== */
        .hero {
            position: relative;
            background:
                linear-gradient(180deg, rgba(2,6,23,0.35) 0%, rgba(2,6,23,0.55) 55%, var(--deep-blue) 100%),
                url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=90');
            background-size: cover; background-position: center; background-attachment: fixed;
            min-height: 86vh; display: flex; align-items: center; justify-content: center; text-align: center;
        }
        .hero-eyebrow {
            display: inline-block; letter-spacing: 5px; font-size: 0.8rem;
            text-transform: uppercase; color: var(--text-muted);
            border: 1px solid var(--border-mid); border-radius: 30px;
            padding: 8px 24px; margin-bottom: 20px;
        }
        .hero h1 { letter-spacing: 4px; }
        .hero-divider {
            width: 70px; height: 2px; background: var(--red-primary);
            margin: 22px auto 26px; border-radius: 2px;
        }
        .btn-explore {
            border: 1px solid rgba(255,255,255,0.5); border-radius: 30px;
            letter-spacing: 2px; transition: 0.3s;
        }
        .btn-explore:hover {
            background-color: var(--red-primary); border-color: var(--red-primary); color: #fff;
        }

        /* ====== CHECK AVAILABILITY ====== */
        .check-availability {
            background-color: var(--card-blue);
            padding: 36px; border-radius: var(--radius-lg);
            margin-top: -70px; position: relative; z-index: 10;
            border: 1px solid var(--border-mid);
            box-shadow: 0 20px 50px rgba(0,0,0,0.45);
        }
        .check-availability .form-label {
            color: var(--text-muted); font-weight: 600; letter-spacing: 1px;
            font-size: 0.78rem; text-transform: uppercase; margin-bottom: 8px;
        }
        .check-availability .form-control,
        .check-availability .form-select {
            background-color: var(--deep-blue);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-sm);
            color: #ffffff;
        }
        .check-availability .form-control:focus,
        .check-availability .form-select:focus {
            border-color: var(--red-primary);
            box-shadow: 0 0 0 3px var(--red-soft);
        }
        .btn-check {
            background-color: var(--red-primary); color: #fff; border: none;
            border-radius: var(--radius-sm); font-weight: 600;
            letter-spacing: 1px; transition: 0.3s;
        }
        .btn-check:hover { background-color: #c92e3a; }

        /* ====== SECTION TITLES ====== */
        .section-title {
            text-align: center; margin-bottom: 16px; font-weight: 800;
            color: #ffffff; text-transform: uppercase; letter-spacing: 4px;
            font-size: 1.9rem;
        }
        .section-title span { color: var(--red-primary); }
        .section-subtitle {
            text-align: center; color: var(--text-muted);
            max-width: 520px; margin: 0 auto 60px; font-size: 0.95rem;
        }
        .section-title::after {
            content: ''; display: block; width: 60px; height: 3px;
            background-color: var(--red-primary); margin: 18px auto 0; border-radius: 3px;
        }

        /* ====== FACILITIES ====== */
        .facilities-wrapper {
            background-color: var(--deep-blue);
            border-top: 1px solid var(--card-blue);
            border-bottom: 1px solid var(--card-blue);
        }
        .card-fasilitas {
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-md);
            background-color: var(--card-blue);
            transition: 0.35s ease;
            cursor: pointer;
            padding: 36px 20px;
        }
        .card-fasilitas:hover {
            transform: translateY(-8px);
            border-color: var(--red-primary);
            background-color: var(--card-blue-light);
        }
        .card-fasilitas .icon-wrap {
            width: 56px; height: 56px; border-radius: 50%;
            background: var(--red-soft); color: var(--red-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin: 0 auto 18px;
        }

        /* ====== ROOM CARDS ====== */
        .rooms-wrapper { background-color: var(--deep-blue); }
        .room-card-new {
            background-color: var(--card-blue);
            border-radius: var(--radius-lg);
            transition: 0.35s ease;
            margin-bottom: 36px;
            border: 1px solid rgba(255,255,255,0.06);
            overflow: hidden;
        }
        .room-card-new:hover {
            transform: translateY(-6px);
            border-color: var(--border-mid);
            box-shadow: 0 20px 45px rgba(230,57,70,0.12);
        }
        .img-wrapper { position: relative; }
        .room-img { height: 320px; width: 100%; object-fit: cover; }
        .price-tag {
            position: absolute; bottom: 16px; right: 16px;
            background-color: rgba(2,6,23,0.9);
            color: var(--red-primary); font-weight: 700;
            padding: 10px 20px; font-size: 1.05rem;
            border-radius: var(--radius-sm); z-index: 10;
            border: 1px solid var(--border-mid);
        }
        .room-meta {
            font-size: 0.85rem; color: var(--text-muted);
            display: flex; flex-wrap: wrap; gap: 18px;
        }
        .room-meta i { color: var(--red-primary); margin-right: 4px; }
        .pesan-sekarang-btn {
            background-color: transparent;
            border: 1px solid var(--red-primary);
            color: var(--red-primary);
            border-radius: 30px;
            font-size: 0.82rem;
            transition: 0.3s;
        }
        .pesan-sekarang-btn:hover {
            background-color: var(--red-primary); color: #ffffff;
        }

        /* ====== AVAILABILITY ALERT ====== */
        .alert-available {
            border: 1px solid var(--border-mid);
            background: var(--red-soft);
            color: var(--text-light);
            border-radius: 30px;
        }

        /* ====== MODAL ====== */
        .modal-content.luxury-modal {
            background-color: var(--card-blue);
            border: 1px solid var(--border-mid);
            border-radius: var(--radius-lg);
        }
        .modal-header.luxury-modal-header {
            border-bottom: 1px solid var(--border-soft);
            color: var(--red-primary);
        }
        .btn-close-white { filter: invert(1); }

        /* ====== FOOTER ====== */
        .footer-premium {
            background-color: #000000;
            border-top: 1px solid var(--border-soft);
        }
        .footer-links a { color: #94a3b8; text-decoration: none; transition: 0.25s; }
        .footer-links a:hover { color: var(--red-primary); }

        /* ====== FLOAT BUTTONS ====== */
        .float-btn {
            width: 56px; height: 56px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white !important; font-size: 26px; text-decoration: none;
            transition: 0.3s; position: fixed; right: 28px; z-index: 9999;
            box-shadow: 0 8px 20px rgba(0,0,0,0.35);
        }
        .float-btn.whatsapp { bottom: 28px; background-color: #25d366; }
        .float-btn.instagram {
            bottom: 96px;
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }
        .float-btn:hover { transform: scale(1.08); }
    </style>
</head>
<body>

<div id="luxury-preloader">
    <i class="fas fa-crown preloader-icon"></i>
    <div class="preloader-text">SANDY HOTEL</div>
    <div class="loading-bar"></div>
</div>

@include('components._navbar')

<section class="hero" data-aos="fade-in" data-aos-duration="1800">
    <div class="container">
        <span class="hero-eyebrow" data-aos="fade-up" data-aos-delay="150">Hotel & resort eksklusif</span>
        <h1 class="display-2 fw-bold mb-0" data-aos="zoom-out" data-aos-delay="300">SANDY HOTEL</h1>
        <div class="hero-divider"></div>
        <p class="lead fs-4 mb-5 fw-light" style="color: var(--text-light);" data-aos="fade-up" data-aos-delay="600">
            Mendefinisikan ulang makna kemewahan
        </p>
        <a href="#rooms" class="btn btn-explore btn-lg px-5 py-3 text-uppercase fw-bold" data-aos="fade-up" data-aos-delay="900">
            Jelajahi kamar <i class="fas fa-chevron-right ms-2"></i>
        </a>
    </div>
</section>

<div class="container">
    <div class="check-availability" data-aos="fade-up" data-aos-delay="1100">
        <form action="{{ url('/') }}#rooms" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Check-in</label>
                <input type="date" name="checkin" value="{{ request('checkin') }}" class="form-control form-control-lg p-3" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Check-out</label>
                <input type="date" name="checkout" value="{{ request('checkout') }}" class="form-control form-control-lg p-3" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Jumlah tamu</label>
                <select name="guests" class="form-select form-select-lg p-3">
                    <option>1 Orang</option><option>2 Orang</option><option>3+ Orang</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-check w-100 py-3 text-uppercase">
                    Cek ketersediaan <i class="fas fa-search ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@include('components._fasilitas')

@php
    $kumpulanFotoKamar = [
        ['https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'],
        ['https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'],
        ['https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1540518614846-7eded433c457?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80', 'https://images.unsplash.com/photo-1505693314120-0d443867891c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80']
    ];
@endphp

<div class="rooms-wrapper py-5">
    <div class="container py-5" id="rooms">
        <div class="text-center">
            <h2 class="section-title" data-aos="fade-up">Koleksi <span>kamar</span> luxury</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                Setiap kamar dirancang untuk kenyamanan dan kemewahan maksimal, lengkap dengan fasilitas premium.
            </p>
            @if(request('checkin') && request('checkout'))
                <div class="alert alert-available d-inline-block px-4 py-2 mb-5">
                    <i class="fas fa-search me-2"></i> Tersedia dari <strong>{{ date('d M Y', strtotime(request('checkin'))) }}</strong> s/d <strong>{{ date('d M Y', strtotime(request('checkout'))) }}</strong>
                    <a href="{{ url('/') }}#rooms" class="ms-3 text-danger text-decoration-none fw-bold"><i class="fas fa-times-circle"></i> Reset</a>
                </div>
            @endif
        </div>

        <div class="row">
            @forelse($daftarKamar ?? [] as $index => $kamar)
            @php $fotoPilihan = $kumpulanFotoKamar[$index % count($kumpulanFotoKamar)]; @endphp

            <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                <div class="room-card-new">
                    <div id="sliderKamar{{ $kamar->id }}" class="carousel slide img-wrapper" data-bs-ride="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active"><img src="{{ $fotoPilihan[0] }}" class="d-block w-100 room-img" alt="Foto 1"></div>
                            <div class="carousel-item"><img src="{{ $fotoPilihan[1] }}" class="d-block w-100 room-img" alt="Foto 2"></div>
                            <div class="carousel-item"><img src="{{ $fotoPilihan[2] }}" class="d-block w-100 room-img" alt="Foto 3"></div>
                        </div>
                        <div class="price-tag">
                            Rp {{ number_format($kamar->price, 0, ',', '.') }} <span class="fw-normal" style="color: var(--text-muted); font-size: 0.8rem;">/ malam</span>
                        </div>
                    </div>

                    <a href="{{ url('/pesan/'.$kamar->id) }}" class="text-decoration-none d-block">
                        <div class="px-4 pt-4">
                            <h3 class="fw-bold mb-3 text-white" style="font-size: 1.4rem;">{{ $kamar->name }}</h3>
                        </div>
                        <div class="px-4 pb-4 room-meta border-top pt-3 mx-4" style="border-color: rgba(255,255,255,0.06) !important;">
                            <span><i class="far fa-square"></i> {{ $kamar->type == 'Studio' ? '45' : ($kamar->type == 'Two' ? '90' : '30') }} Sq Ft</span>
                            <span><i class="fas fa-bed"></i> {{ $kamar->type == 'Two' ? '2' : '1' }} Bed</span>
                            <div class="w-100 mt-3 text-end">
                                <span class="btn pesan-sekarang-btn px-5 py-2 text-uppercase fw-bold">Pesan sekarang <i class="fas fa-arrow-right ms-2"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-sad-tear fa-4x mb-3" style="color: var(--text-muted);"></i>
                <h3 class="fw-bold" style="color: var(--text-muted);">Maaf, semua kamar penuh</h3>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('components._footer')

<div class="modal fade" id="welcomeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content luxury-modal">
            <div class="row g-0">
                <div class="col-md-5 d-none d-md-block">
                    <img src="https://images.unsplash.com/photo-1542314831-c6a4d1409b1c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Luxury Sandy Hotel" style="width: 100%; height: 100%; object-fit: cover; border-radius: var(--radius-lg) 0 0 var(--radius-lg);">
                </div>
                <div class="col-md-7 d-flex align-items-center">
                    <div class="modal-body p-5 text-center text-white">
                        <i class="fas fa-crown fa-4x mb-3" style="color: var(--red-primary);"></i>
                        <h2 class="fw-bold mb-3" style="color: var(--red-primary);">
                            Selamat datang, {{ Auth::check() ? Auth::user()->name : 'Tamu Kehormatan' }}!
                        </h2>
                        <button type="button" class="btn btn-check rounded-pill px-5 py-3 mt-3" data-bs-dismiss="modal">Mulai eksplorasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="#" class="float-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
<a href="#" class="float-btn instagram"><i class="fab fa-instagram"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    AOS.init({ duration: 1200, once: true, offset: 120, easing: 'ease-out-back' });

    window.addEventListener('load', function() {
        const preloader = document.getElementById('luxury-preloader');
        setTimeout(function() { preloader.classList.add('preloader-hidden'); }, 1000);
    });

    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('smartNavbar');
        if (navbar) {
            if (window.scrollY > 80) navbar.classList.add('navbar-scrolled');
            else navbar.classList.remove('navbar-scrolled');
        }
    });
</script>

@if(session('welcome_login'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('welcomeModal'), { keyboard: false });
        setTimeout(function() { myModal.show(); }, 1500);
    });
</script>
@endif

@if(session('sukses'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('sukses') }}',
        confirmButtonColor: '#e63946',
        background: '#0f172a',
        color: '#ffffff'
    });
</script>
@endif

@if(session('error_booking'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops! Gagal memesan',
        text: '{{ session('error_booking') }}',
        confirmButtonText: 'Cari kamar lain',
        confirmButtonColor: '#e63946',
        background: '#0f172a',
        color: '#ffffff',
        backdrop: `rgba(0,0,0,0.8)`
    });
</script>
@endif

</body>
</html>