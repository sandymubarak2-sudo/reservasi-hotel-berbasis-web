<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    public function update(Request $request, Room $room): mixed
    {
        $validated = $this->validateRoom($request);
        if(!empty($validated->headers))
            return $validated;

        // --- TAMBAHAN: Proses Upload Foto saat Update Data ---
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_foto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $nama_foto);
            $validated['foto'] = $nama_foto;
        }

        $room = $this->updateRoom($validated, $room);
        if(empty($room->id))
            return $room;

        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully',
            'data' => $room,
        ], 201);
    }

    public function store(Request $request): mixed
    {
        $validated = $this->validateRoom($request);
        if(!empty($validated->headers))
            return $validated;

        // --- TAMBAHAN: Proses Upload Foto saat Tambah Kamar Baru ---
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Membuat nama unik agar foto tidak tertimpa
            $nama_foto = time() . '_' . $file->getClientOriginalName();
            
            // Memindahkan file foto fisik ke folder public/images
            $file->move(public_path('images'), $nama_foto);
            
            // Memasukkan nama file ke dalam array data yang akan di-save
            $validated['foto'] = $nama_foto; 
        }

        $room = $this->createRoom($validated);
        if(empty($room->id))
            return $room;

        // Catatan Penting: Jika setelah submit form halamannya berubah jadi teks JSON putih,
        // ubah blok return response()->json(...) di bawah ini menjadi:
        // return redirect('/admin/kamar')->with('sukses', 'Kamar berhasil ditambahkan!');

        return response()->json([
            'success' => true,
            'message' => 'Room created successfully',
            'data' => $room,
        ], 201);
    }

    public function show(Room $room)
    {
        $get = Room::with('bookings')->find($room->id);
        return response()->json(['success' => true, 'room' => $get], 201);
    }

    public function remove(Room $room)
    {
        $room->delete();
        return response()->json(['success' => true, 'message' => 'Room deleted successfully'], 201);
    }

    private function validateRoom(Request $request): mixed
    {
        try {
            $validatedData = $request->validate([
                'number' => 'required|integer',
                'name' => 'required|string',
                'price' => 'required|numeric',
                'type' => 'required|in:' . Room::TYPE_ONE . ',' . Room::TYPE_STUDIO . ',' . Room::TYPE_TWO,
                // --- TAMBAHAN: Syarat Validasi Foto ---
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
            ]);
        } catch (ValidationException $e){
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()->getMessages(),
            ], 422);
        }

        return $validatedData;
    }

    private function createRoom($validatedData): mixed
    {
        try {
            $room = Room::create($validatedData);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()->getMessages(),
            ], 422);
        }

        return $room;
    }

    private function updateRoom($validatedData, Room $room): mixed
    {
        try {
            $room->update($validatedData);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()->getMessages(),
            ], 422);
        }

        return $room;
    }
}