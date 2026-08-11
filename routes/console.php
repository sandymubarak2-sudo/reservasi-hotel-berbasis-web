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
// 1. RUTE HALAMAN UTAMA (USER)
// ==========================================
Route::get('/', function () {
    $kamarAsli = Room::all(); 
    return view('kamar', ['daftarKamar' => $kamarAsli]);
});

// ==========================================
// 2. RUTE AUTH (LOGIN & REGISTER)
// ==========================================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'pelanggan' 
    ]);
    Auth::login($user);
    return redirect('/');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        if (Auth::user()->role === 'admin') {
            return redirect('/admin');
        }
        return redirect('/');
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
// 3. RUTE PEMESANAN & RIWAYAT (USER)
// ==========================================
Route::get('/pesan/{id}', function ($id) {
    $kamar = Room::find($id);
    return view('booking', ['kamar' => $kamar]);
})->middleware('auth');

Route::post('/pesan/{id}', function (Request $request, $id) {
    $kamar = Room::find($id);
    $customer = Customer::firstOrCreate(
        ['email' => Auth::user()->email],
        ['name' => Auth::user()->name, 'phone' => $request->phone]
    );

    $start = new \DateTime($request->start_date);
    $end = new \DateTime($request->end_date);
    $durasi = $start->diff($end)->days;
    if ($durasi == 0) { $durasi = 1; }
    
    Booking::create([
        'customer_id' => $customer->id,
        'room_id' => $kamar->id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'price' => $durasi * $kamar->price,
    ]);

    return redirect('/')->with('sukses', 'Hore! Kamar berhasil dipesan.');
})->middleware('auth');

Route::get('/riwayat', function () {
    $customer = Customer::where('email', Auth::user()->email)->first();
    $pesanan = $customer ? Booking::where('customer_id', $customer->id)->with('room')->get() : [];
    return view('riwayat', ['daftarPesanan' => $pesanan]);
})->middleware('auth')->name('riwayat');

// ==========================================
// 4. KELOMPOK RUTE ADMIN (CHART.JS INCLUDED)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // DASHBOARD UTAMA DENGAN LOGIKA GRAFIK
    Route::get('/admin', function () {
        if (Auth::user()->role !== 'admin') return redirect('/');

        // 1. Ambil data pesanan 7 hari terakhir untuk Grafik
        $dataGrafik = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // 2. Pisahkan tanggal dan jumlahnya untuk Chart.js
        $labels = $dataGrafik->pluck('date');
        $totals = $dataGrafik->pluck('total');

        return view('admin.dashboard', [
            'pesanan' => Booking::with(['customer', 'room'])->latest()->get(),
            'totalKamar' => Room::count(),
            'totalPesanan' => Booking::count(),
            'totalPendapatan' => Booking::sum('price'),
            'labels' => $labels,
            'totals' => $totals
        ]);
    });

    // Rute Admin Lainnya
    Route::get('/admin/reservasi', function () {
        if (Auth::user()->role !== 'admin') return redirect('/');
        return view('admin.reservasi', ['daftarPesanan' => Booking::with(['customer', 'room'])->latest()->get()]);
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
            'totalPendapatan' => Booking::sum('price')
        ]);
    });

    // CRUD Kamar (Tambah, Edit, Hapus)
    Route::get('/admin/kamar/tambah', function () { return view('admin.tambah_kamar'); });
    Route::post('/admin/kamar/tambah', function (Request $request) {
        Room::create($request->all());
        return redirect('/admin/kamar')->with('sukses', 'Kamar ditambah!');
    });
    Route::get('/admin/kamar/edit/{id}', function ($id) { return view('admin.edit_kamar', ['kamar' => Room::find($id)]); });
    Route::post('/admin/kamar/edit/{id}', function (Request $request, $id) {
        Room::find($id)->update($request->all());
        return redirect('/admin/kamar')->with('sukses', 'Kamar diperbarui!');
    });
    Route::get('/admin/kamar/hapus/{id}', function ($id) {
        Room::destroy($id);
        return redirect('/admin/kamar')->with('sukses', 'Kamar dihapus!');
    });
});