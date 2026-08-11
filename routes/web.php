<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Customer;

// ==========================================
// RUTE RAHASIA: MEMBUAT AKUN PETUGAS & ADMIN
// ==========================================
Route::get('/buat-petugas', function () {
    User::firstOrCreate(
        ['email' => 'petugas@sandyhotel.com'],
        [
            'name' => 'Resepsionis',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas'
        ]
    );
    return 'Akun Petugas berhasil dibuat! Email: petugas@sandyhotel.com | Pass: petugas123';
});

// ==========================================
// 1. RUTE HALAMAN UTAMA (PELANGGAN)
// ==========================================
Route::get('/', function (Request $request) {
    $checkin = $request->input('checkin');
    $checkout = $request->input('checkout');

    if ($checkin && $checkout) {
        $kamarTerpakai = Booking::where(function($query) use ($checkin, $checkout) {
            $query->where('start_date', '<', $checkout)
                  ->where('end_date', '>', $checkin);
        })->pluck('room_id');
        $kamarAsli = Room::whereNotIn('id', $kamarTerpakai)->get();
    } else {
        $kamarAsli = Room::all();
    }
    return view('kamar', ['daftarKamar' => $kamarAsli]);
});

// ==========================================
// 2. RUTE AUTH (LOGIN, REGISTER, LOGOUT)
// ==========================================
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');

Route::post('/register', function (Request $request) {
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'pelanggan' 
    ]);
    Auth::login($user);
    return redirect('/')->with('welcome_login', true);
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect('/admin'); 
        } elseif ($role === 'petugas') {
            return redirect('/petugas'); 
        }
        
        // Mengirim sinyal 'welcome_login' untuk pelanggan
        return redirect('/')->with('welcome_login', true); 
    }
    return back()->withErrors(['email' => 'Email atau password salah!']);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// ==========================================
// 3. RUTE PEMESANAN & RIWAYAT (PELANGGAN)
// ==========================================
Route::get('/pesan/{id}', function ($id) {
    return view('booking', ['kamar' => Room::find($id)]);
})->middleware('auth');

Route::post('/pesan/{id}', function (Request $request, $id) {
    $kamar = Room::find($id);
    $checkin = $request->start_date;
    $checkout = $request->end_date;

    $bentrok = Booking::where('room_id', $kamar->id)
        ->where(function($query) use ($checkin, $checkout) {
            $query->where('start_date', '<', $checkout)->where('end_date', '>', $checkin);
        })->exists();

    if ($bentrok) return redirect('/')->with('error_booking', 'Maaf! Kamar ini sudah dipesan oleh orang lain pada tanggal tersebut.');

    $customer = Customer::firstOrCreate(
        ['email' => Auth::user()->email],
        ['name' => Auth::user()->name, 'phone' => $request->phone]
    );

    $start = new \DateTime($checkin);
    $end = new \DateTime($checkout);
    $durasi = max(1, $start->diff($end)->days);
    
    Booking::create([
        'customer_id' => $customer->id, 'room_id' => $kamar->id,
        'start_date' => $checkin, 'end_date' => $checkout,
        'price' => $durasi * $kamar->price, 'status' => 'Menunggu Pembayaran'
    ]);

    return redirect('/')->with('sukses', 'Hore! Kamar berhasil dipesan.');
})->middleware('auth');

Route::get('/riwayat', function () {
    $customer = Customer::where('email', Auth::user()->email)->first();
    $pesanan = $customer ? Booking::where('customer_id', $customer->id)->with('room')->get() : [];
    return view('riwayat', ['daftarPesanan' => $pesanan]);
})->middleware('auth')->name('riwayat');

Route::post('/bayar/{id}', function (Request $request, $id) {
    $pesanan = Booking::find($id);
    if ($request->hasFile('bukti_pembayaran')) {
        $path = $request->file('bukti_pembayaran')->store('public/bukti');
        $pesanan->update(['bukti_pembayaran' => str_replace('public/', 'storage/', $path), 'status' => 'Menunggu Verifikasi Admin']);
    }
    return back()->with('sukses', 'Bukti transfer berhasil dikirim! Silakan tunggu konfirmasi.');
})->middleware('auth');

Route::get('/cetak-struk/{id}', function ($id) {
    $pesanan = Booking::with(['customer', 'room'])->findOrFail($id);
    if ($pesanan->status !== 'Lunas') return redirect('/riwayat')->with('error', 'Maaf, struk hanya bisa dicetak untuk pesanan Lunas.');
    return view('invoice', ['pesanan' => $pesanan]);
})->middleware('auth');


// ==========================================
// 4. KELOMPOK RUTE PETUGAS (RESEPSIONIS)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Utama Petugas
    Route::get('/petugas', function () {
        if (Auth::user()->role !== 'petugas') return redirect('/');

        $kedatanganHariIni = Booking::with(['customer', 'room'])
            ->whereDate('start_date', now()) 
            ->get();

        return view('petugas.dashboard', [
            'totalPesanan' => Booking::count(),
            'pesananBaru' => Booking::where('status', 'Menunggu Verifikasi Admin')->count(),
            'pesanan' => Booking::with(['customer', 'room'])->latest()->take(5)->get(),
            'kedatanganHariIni' => $kedatanganHariIni 
        ]);
    });

    // Halaman Jadwal Kedatangan
    Route::get('/petugas/kedatangan', function () {
        if (Auth::user()->role !== 'petugas') return redirect('/');
        $kedatangan = Booking::with(['customer', 'room'])
            ->where('status', 'Lunas')
            ->get();
        return view('petugas.kedatangan', ['daftarKedatangan' => $kedatangan]);
    });

    // Halaman Status Kamar Aktif
    Route::get('/petugas/kamar-aktif', function () {
        if (Auth::user()->role !== 'petugas') return redirect('/');
        $kamarAktif = Booking::with(['customer', 'room'])
            ->where('status', 'Sedang Menginap')
            ->get();
        return view('petugas.kamar-aktif', ['kamarAktif' => $kamarAktif]);
    });

    // Manajemen Status Lapangan
    Route::get('/petugas/reservasi', function () {
        if (Auth::user()->role !== 'petugas') return redirect('/');
        return view('petugas.reservasi', ['daftarPesanan' => Booking::with(['customer', 'room'])->latest()->get()]);
    });

    // FITUR AUDIT TRAIL
    Route::get('/petugas/reservasi/lunas/{id}', function ($id) {
        if (Auth::user()->role !== 'petugas') return redirect('/');
        Booking::find($id)->update([
            'status' => 'Lunas',
            'handled_by' => Auth::user()->name,
            'handled_at' => now()
        ]);
        return back()->with('sukses', 'Pembayaran berhasil diverifikasi oleh Petugas!');
    });

    Route::get('/petugas/reservasi/checkin/{id}', function ($id) {
        if (Auth::user()->role !== 'petugas') return redirect('/');
        Booking::find($id)->update([
            'status' => 'Sedang Menginap',
            'handled_by' => Auth::user()->name,
            'handled_at' => now()
        ]);
        return back()->with('sukses', 'Tamu berhasil Check-In! Silakan berikan kunci kamar.');
    });

    Route::get('/petugas/reservasi/checkout/{id}', function ($id) {
        if (Auth::user()->role !== 'petugas') return redirect('/');
        Booking::find($id)->update([
            'status' => 'Selesai',
            'handled_by' => Auth::user()->name,
            'handled_at' => now()
        ]);
        return back()->with('sukses', 'Tamu berhasil Check-Out. Terima kasih!');
    });

    Route::get('/petugas/reservasi/hapus/{id}', function ($id) {
        if (Auth::user()->role !== 'petugas') return redirect('/');
        Booking::destroy($id);
        return back()->with('sukses', 'Data reservasi berhasil dihapus dari sistem!');
    });
});


// ==========================================
// 5. KELOMPOK RUTE ADMIN (FULL AKSES)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/admin', function () {
        if (Auth::user()->role !== 'admin') return redirect('/');
        
        $dataGrafik = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))->groupBy('date')->orderBy('date', 'ASC')->get();
            
        return view('admin.dashboard', [
            'pesanan' => Booking::with(['customer', 'room'])->latest()->get(),
            'totalKamar' => Room::count(), 
            'totalPesanan' => Booking::count(),
            'totalPendapatan' => Booking::where('status', 'Lunas')->sum('price'),
            'labels' => $dataGrafik->pluck('date'), 
            'totals' => $dataGrafik->pluck('total') 
        ]);
    });

    // === FITUR RAHASIA: EXPORT LAPORAN EXCEL/CSV ===
    Route::get('/admin/export-laporan', function () {
        if (Auth::user()->role !== 'admin') return redirect('/');

        $namaFile = "Laporan_Pendapatan_Hotel_" . date('Y-m-d') . ".csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$namaFile",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        // Hanya mengambil data yang sudah Lunas atau Selesai
        $pesanan = Booking::with(['customer', 'room'])
            ->whereIn('status', ['Lunas', 'Selesai'])
            ->get();

        $callback = function() use($pesanan) {
            $file = fopen('php://output', 'w');
            
            // Baris 1: Judul Kolom Excel
            fputcsv($file, ['ID Pesanan', 'Nama Tamu', 'No Kamar', 'Tipe Kamar', 'Tanggal Check-In', 'Tanggal Check-Out', 'Total Pendapatan (Rp)', 'Petugas Penanggung Jawab']);

            // Baris 2 dst: Isi Data
            foreach ($pesanan as $p) {
                fputcsv($file, [
                    'INV-' . str_pad($p->id, 5, '0', STR_PAD_LEFT),
                    $p->customer->name ?? '-',
                    'KM-' . ($p->room->number ?? '0'),
                    $p->room->type ?? '-',
                    $p->start_date,
                    $p->end_date,
                    $p->price,
                    $p->handled_by ?? 'Sistem'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    });
    // ===============================================

    Route::get('/admin/reservasi', function () {
        if (Auth::user()->role !== 'admin') return redirect('/');
        return view('admin.reservasi', ['daftarPesanan' => Booking::with(['customer', 'room'])->latest()->get()]);
    });

    // FITUR AUDIT TRAIL UNTUK ADMIN
    Route::get('/admin/reservasi/lunas/{id}', function ($id) {
        if (Auth::user()->role !== 'admin') return redirect('/');
        Booking::find($id)->update([
            'status' => 'Lunas',
            'handled_by' => Auth::user()->name,
            'handled_at' => now()
        ]);
        return back()->with('sukses', 'Pembayaran berhasil diverifikasi!');
    });

    Route::get('/admin/kamar', function () {
        if (Auth::user()->role !== 'admin') return redirect('/');
        return view('admin.kamar', ['daftarKamar' => Room::all()]);
    });

    Route::get('/admin/tamu', function () {
        if (Auth::user()->role !== 'admin') return redirect('/');
        return view('admin.tamu', ['daftarTamu' => Customer::all()]);
    });

    Route::get('/admin/keuangan', function () {
        if (Auth::user()->role !== 'admin') return redirect('/');
        return view('admin.keuangan', [
            'daftarPesanan' => Booking::with(['customer', 'room'])->get(), 
            'totalPendapatan' => Booking::whereIn('status', ['Lunas', 'Selesai'])->sum('price')
        ]);
    });

    // CRUD Kamar (Hanya Admin)
    Route::get('/admin/kamar/tambah', function () {
        if (Auth::user()->role !== 'admin') return redirect('/');
        return view('admin.tambah_kamar');
    });
    
    Route::post('/admin/kamar/tambah', function (Request $request) {
        if (Auth::user()->role !== 'admin') return redirect('/');
        Room::create($request->only(['name', 'number', 'type', 'price']));
        return redirect('/admin/kamar')->with('sukses', 'Kamar berhasil ditambah!');
    });
    
    Route::get('/admin/kamar/edit/{id}', function ($id) {
        if (Auth::user()->role !== 'admin') return redirect('/');
        return view('admin.edit_kamar', ['kamar' => Room::find($id)]);
    });
    
    Route::post('/admin/kamar/edit/{id}', function (Request $request, $id) {
        if (Auth::user()->role !== 'admin') return redirect('/');
        Room::find($id)->update($request->all());
        return redirect('/admin/kamar')->with('sukses', 'Kamar diperbarui!');
    });
    
    Route::get('/admin/kamar/hapus/{id}', function ($id) {
        if (Auth::user()->role !== 'admin') return redirect('/');
        Room::destroy($id);
        return redirect('/admin/kamar')->with('sukses', 'Kamar dihapus!');
    });
});