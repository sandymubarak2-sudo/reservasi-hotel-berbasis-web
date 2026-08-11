<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sandy Hotel</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { 
            --gold-primary: #d4af37; 
            --dark-bg: #1a1a1a; 
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            /* Background Gambar Hotel Mewah */
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95); /* Sedikit transparan (Glassmorphism) */
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            border-top: 5px solid var(--gold-primary);
        }

        .login-header h2 {
            font-family: 'Playfair Display', serif;
            color: var(--dark-bg);
            font-weight: 700;
            letter-spacing: 1px;
        }

        .login-header i {
            color: var(--gold-primary);
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
            border-color: var(--gold-primary);
            background-color: #fff;
        }

        .input-group-text {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-right: none;
            color: #888;
        }
        
        .form-control { border-left: none; }

        .btn-login {
            background-color: var(--gold-primary);
            color: #000;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-login:hover {
            background-color: #bfa030;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
            color: #000;
        }

        .register-link {
            color: var(--dark-bg);
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .register-link:hover {
            color: var(--gold-primary);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header text-center mb-4">
            <i class="fas fa-crown"></i>
            <h2>SANDY HOTEL</h2>
            <p class="text-muted small">Silakan masuk ke akun Anda</p>
        </div>

        <!-- Tampilkan Error Jika Email/Password Salah -->
        @if($errors->any())
            <div class="alert alert-danger py-2 small border-0 shadow-sm">
                <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-semibold small text-muted text-uppercase">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email terdaftar" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between">
                    <label class="form-label fw-semibold small text-muted text-uppercase">Password</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
                </div>
            </div>

            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-login text-uppercase">Masuk Sekarang</button>
            </div>
            
            <div class="text-center mt-3 border-top pt-3">
                <span class="text-muted small">Belum memiliki akun?</span> 
                <a href="{{ url('/register') }}" class="register-link small">Daftar di sini</a>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ url('/') }}" class="text-muted small text-decoration-none hover-warning">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>