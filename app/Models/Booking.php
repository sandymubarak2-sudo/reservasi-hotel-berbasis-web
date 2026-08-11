<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'room_id',
        'start_date',
        'end_date',
        'price',
        'status',           // Kolom baru untuk status pembayaran
        'bukti_pembayaran', // Kolom baru untuk menyimpan foto struk
        'handled_by',       // FITUR AUDIT: Menyimpan nama petugas
        'handled_at',       // FITUR AUDIT: Menyimpan waktu eksekusi
    ];

    protected $table = 'booking';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }
}