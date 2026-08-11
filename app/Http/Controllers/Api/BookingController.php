<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Events\NewBooking;
use App\Events\ChangeBooking;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function show(Booking $booking)
    {
        $get = Booking::with('payments', 'room', 'customer')->find($booking->id);
        return response()->json(['success' => true, 'booking' => $get], 201);
    }

    public function store(Request $request)
    {
        $validated = $this->validateBooking($request, true);
        if(!empty($validated->headers))
            return $validated;

        $booking = $this->createBooking($validated);
        if(empty($booking->id))
            return $booking;

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking,
        ], 201);
    }

    public function update(Request $request, Booking $booking): mixed
    {
        // Mengirimkan ID booking saat ini agar saat update tidak dianggap bentrok dengan diri sendiri
        $validated = $this->validateBooking($request, false, $booking->id);
        if(!empty($validated->headers))
            return $validated;

        $booking = $this->updateBooking($validated, $booking);
        if(empty($booking->id))
            return $booking;

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking,
        ], 201);
    }

    public function remove(Booking $booking)
    {
        $booking->delete();
        return response()->json(['success' => true, 'message' => 'Booking deleted successfully'], 201);
    }

    private function validateBooking(Request $request, $create = true, $bookingId = null): mixed
    {
        // 1. Validasi tipe data dan keharusan isi (bawaan Laravel)
        try {
            $validatedData = $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'price' => 'required|numeric|min:0',
                'room_id' => 'required|exists:room,id',
                'customer_id' => 'required|exists:customer,id',
                // unique validasi aslinya dikomentari/dihapus agar tidak konflik dengan array format, 
                // karena kita sudah punya validasi manual di bawah.
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()->getMessages(),
            ], 422);
        }

        // 2. Validasi Kombinasi Kamar dan Pelanggan (Kode Aslimu)
        if($create){
            $checkRoomAndCustomer = $this->checkRoomAndCustomer($request);
            if($checkRoomAndCustomer !== true)
                return $checkRoomAndCustomer;
        }

        // 3. TAMBAHAN: Validasi Jadwal Bentrok (Overlapping Booking)
        $checkOverlap = $this->checkOverlappingBooking($request, $bookingId);
        if($checkOverlap !== true)
            return $checkOverlap;

        return $validatedData;
    }

    private function checkRoomAndCustomer(Request $request): mixed
    {
        $booking = Booking::where('customer_id', $request->input('customer_id'))
                          ->where('room_id', $request->input('room_id'))
                          ->first();

        if ($booking) {
            return response()->json([
                'success' => false,
                'message' => 'This customer and room combination already exists!',
            ], 422);
        }

        return true;
    }

    // --- FITUR BARU: CEK JADWAL BENTROK ---
    private function checkOverlappingBooking(Request $request, $ignoreBookingId = null): mixed
    {
        $query = Booking::where('room_id', $request->input('room_id'))
            ->where(function ($q) use ($request) {
                // Logika Bentrok: Check-In baru < Check-Out lama & Check-Out baru > Check-In lama
                $q->where('start_date', '<', $request->input('end_date'))
                  ->where('end_date', '>', $request->input('start_date'));
            });

        // Jika sedang melakukan Update, abaikan pesanan ini sendiri agar tidak salah deteksi
        if ($ignoreBookingId) {
            $query->where('id', '!=', $ignoreBookingId);
        }

        $overlap = $query->first();

        // Jika ada jadwal yang bentrok, tolak dengan format JSON API
        if ($overlap) {
            return response()->json([
                'success' => false,
                'message' => 'Booking failed. The room is already booked for these dates.',
            ], 422);
        }

        return true;
    }

    private function createBooking($validatedData): mixed
    {
        try {
            $booking = Booking::create($validatedData);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()->getMessages(),
            ], 422);
        }

        event(new NewBooking($booking->id));
        return $booking;
    }

    private function updateBooking($validatedData, Booking $booking): mixed
    {
        $oldBooking = clone $booking;

        try {
            $booking->update($validatedData);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()->getMessages(),
            ], 422);
        }

        event(new ChangeBooking($booking, $oldBooking));

        return $booking;
    }
}