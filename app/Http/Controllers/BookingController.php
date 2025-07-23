<?php
// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Menampilkan form booking.
     */
    public function index()
    {
        // Ambil semua layanan dan barber untuk ditampilkan di form
        $services = Service::all();
        $barbers = Barber::all();

        // Buat daftar jam dari 09.00 sampai 20.00
        $times = [];
        for ($i = 9; $i <= 20; $i++) {
            $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            $times[] = $time;
        }

        return view('booking', compact('services', 'barbers', 'times'));
    }

    /**
     * Menyimpan booking baru.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'required|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id', // Pastikan setiap ID layanan ada di tabel services
            'barber_id' => 'required|exists:barbers,id', // Pastikan ID barber ada di tabel barbers
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi foto
            'notes' => 'nullable|string|max:1000',
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'customer_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'booking_date.required' => 'Tanggal booking wajib diisi.',
            'booking_date.date' => 'Format tanggal tidak valid.',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
            'booking_time.required' => 'Jam booking wajib diisi.',
            'booking_time.date_format' => 'Format jam tidak valid (HH:MM).',
            'service_ids.required' => 'Pilih setidaknya satu layanan.',
            'service_ids.array' => 'Layanan harus dalam format array.',
            'service_ids.min' => 'Pilih setidaknya satu layanan.',
            'service_ids.*.exists' => 'Layanan yang dipilih tidak valid.',
            'barber_id.required' => 'Pilih barberman.',
            'barber_id.exists' => 'Barberman yang dipilih tidak valid.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar yang diizinkan: JPG, JPEG, PNG.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Simpan foto ke storage/app/public/bookings
            $photoPath = $request->file('photo')->store('bookings', 'public');
        }

        // Buat booking baru
        Booking::create([
            'customer_name' => $request->customer_name,
            'customer_whatsapp' => $request->customer_whatsapp,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'service_ids' => json_encode($request->service_ids), // Simpan sebagai JSON string
            'barber_id' => $request->barber_id,
            'photo_path' => $photoPath,
            'notes' => $request->notes,
            'status' => 'pending', // Status awal booking
        ]);

        // Redirect ke halaman sukses
        return redirect()->route('booking.success');
    }

    /**
     * Menampilkan halaman sukses booking.
     */
    public function success()
    {
        return view('booking-success');
    }
}
