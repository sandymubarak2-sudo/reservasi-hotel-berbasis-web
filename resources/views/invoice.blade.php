<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket Reservasi - SANDY HOTEL</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            var(--primary): #e63946;
            var(--dark): #020617;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .ticket-wrapper {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            display: flex;
            max-width: 850px;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        /* Desain Kiri (Detail) */
        .ticket-left {
            flex: 2.5;
            padding: 40px;
            background: white;
            border-right: 3px dashed #cbd5e1;
            position: relative;
        }

        /* Setengah lingkaran bolong untuk efek tiket */
        .ticket-left::after, .ticket-right::before {
            content: '';
            position: absolute;
            width: 40px; height: 40px;
            background-color: #f1f5f9;
            border-radius: 50%;
            top: -20px; right: -20px;
        }
        .ticket-left::before, .ticket-right::after {
            content: '';
            position: absolute;
            width: 40px; height: 40px;
            background-color: #f1f5f9;
            border-radius: 50%;
            bottom: -20px; right: -20px;
        }
        .ticket-right::before { left: -20px; right: auto; top: -20px; }
        .ticket-right::after { left: -20px; right: auto; bottom: -20px; }

        /* Desain Kanan (QR Code) */
        .ticket-right {
            flex: 1;
            background: #e63946; /* Velvet Red */
            color: white;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 15px;
        }
        .header h1 { margin: 0; font-size: 1.8rem; color: #020617; font-weight: 800; letter-spacing: 1px; }
        .header .status { background: #10b981; color: white; padding: 5px 15px; border-radius: 50px; font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;}

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        .info-box p { margin: 0 0 5px 0; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        .info-box h3 { margin: 0; color: #0f172a; font-size: 1.2rem; }

        .room-details {
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qr-box {
            background: white;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .qr-box img { width: 140px; height: 140px; display: block; }
        
        .ticket-right h2 { margin: 0 0 5px 0; font-size: 1.2rem; letter-spacing: 2px; }
        .ticket-right p { margin: 0; font-size: 0.85rem; opacity: 0.9; }

        .btn-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #020617;
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-print:hover { background: #e63946; transform: translateY(-3px); }

        /* Sembunyikan elemen tidak penting saat di-print ke PDF */
        @media print {
            body { background: white; padding: 0; align-items: flex-start; }
            .ticket-wrapper { box-shadow: none; max-width: 100%; border: 1px solid #ccc; }
            .ticket-left::after, .ticket-right::before, .ticket-left::before, .ticket-right::after { display: none; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="ticket-wrapper">
        <div class="ticket-left">
            <div class="header">
                <h1><i class="fas fa-crown" style="color: #e63946;"></i> SANDY HOTEL</h1>
                <span class="status"><i class="fas fa-check-circle"></i> E-TICKET VALID</span>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <p><i class="fas fa-user me-2"></i> Nama Tamu</p>
                    <h3>{{ $pesanan->customer->name ?? 'Tamu Hotel' }}</h3>
                </div>
                <div class="info-box">
                    <p><i class="fas fa-file-invoice me-2"></i> No. Invoice</p>
                    <h3>INV-{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}</h3>
                </div>
                <div class="info-box">
                    <p><i class="fas fa-sign-in-alt me-2"></i> Check-In</p>
                    <h3>{{ date('d M Y', strtotime($pesanan->start_date)) }}</h3>
                    <small style="color: #64748b;">Mulai 14:00 WIB</small>
                </div>
                <div class="info-box">
                    <p><i class="fas fa-sign-out-alt me-2"></i> Check-Out</p>
                    <h3>{{ date('d M Y', strtotime($pesanan->end_date)) }}</h3>
                    <small style="color: #e63946; font-weight: bold;">Maks 12:00 WIB</small>
                </div>
            </div>

            <div class="room-details">
                <div>
                    <h3 style="margin: 0; color: #0f172a; font-size: 1.4rem;">
                        <i class="fas fa-door-closed" style="color: #e63946;"></i> Kamar {{ $pesanan->room->number ?? '0' }}
                    </h3>
                    <p style="margin: 5px 0 0 0; color: #64748b; font-weight: 500;">Tipe: {{ $pesanan->room->type ?? 'Standard' }}</p>
                </div>
                <div style="text-align: right;">
                    <p style="margin: 0; color: #64748b; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">Total Lunas</p>
                    <h2 style="margin: 0; color: #10b981; font-size: 1.6rem;">Rp {{ number_format($pesanan->price, 0, ',', '.') }}</h2>
                </div>
            </div>
            
            <div style="margin-top: 20px; text-align: center; color: #94a3b8; font-size: 0.8rem;">
                <p>Harap tunjukkan E-Ticket atau QR Code ini kepada resepsionis saat melakukan Check-In.</p>
            </div>
        </div>

        <div class="ticket-right">
            <h2 style="font-size: 1.4rem; margin-bottom: 15px;">SCAN AREA</h2>
            <div class="qr-box">
                @php
                    $qrData = "INV-" . str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) . "-" . preg_replace('/\s+/', '', $pesanan->customer->name ?? 'Tamu') . "-LUNAS";
                @endphp
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $qrData }}&color=020617&bgcolor=ffffff" alt="QR Code E-Ticket">
            </div>
            <h2>BOARDING</h2>
            <p>PASS TICKET</p>
            <p style="margin-top: 15px; font-size: 0.7rem; opacity: 0.7;">Disahkan oleh Sistem</p>
        </div>
    </div>

    <button class="btn-print" onclick="window.print()">
        <i class="fas fa-print"></i> Simpan ke PDF / Cetak
    </button>

</body>
</html>