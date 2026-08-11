<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // Nama tabel manual karena database kamu menggunakan 'room' (tunggal)
    protected $table = 'room';
    
    // Mengizinkan semua kolom diisi agar tidak error 'Mass Assignment' lagi
    protected $guarded = []; 

    // Konstanta untuk tipe kamar agar sesuai dengan ENUM di database kamu
    const TYPE_ONE = 'One';
    const TYPE_STUDIO = 'Studio';
    const TYPE_TWO = 'Two';

    // Memastikan harga selalu diproses sebagai angka (double)
    protected $casts = [
        'price' => 'double',
    ];

    /**
     * Relasi ke tabel Booking (Satu kamar bisa punya banyak pesanan)
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id');
    }
}