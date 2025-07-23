<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Barber;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Carbon\Carbon; // Untuk manipulasi tanggal

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    /**
     * Menampilkan dashboard 
     */
    public function dashboard()
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';
        $today = now()->toDateString();
        $thisWeekStart = now()->startOfWeek();
        $thisWeekEnd = now()->endOfWeek();

        // Query dasar Booking berdasarkan role
        $bookingQuery = Booking::query();

        if (!$isAdmin) {
            // Dapatkan ID barber yang terhubung ke user ini
            $barber = Barber::where('user_id', $user->id)->first();

            if (!$barber) {
                // Barber belum punya profil → redirect atau tampilkan error
                abort(403, 'Anda belum terdaftar sebagai barber.');
            }

            $bookingQuery->where('barber_id', $barber->id);
        }

        // Hitung jumlah booking hari ini
        $todayBookingsCount = (clone $bookingQuery)
            ->whereDate('booking_date', $today)
            ->count();

        // Hitung jumlah booking minggu ini
        $thisWeekBookings = (clone $bookingQuery)
            ->whereBetween('booking_date', [$thisWeekStart, $thisWeekEnd])
            ->get();

        $thisWeekBookingsCount = $thisWeekBookings->count();

        // Ambil daftar antrian hari ini (urut jam)
        $todayBookings = (clone $bookingQuery)
            ->whereDate('booking_date', $today)
            ->with('barber')
            ->orderBy('booking_time', 'asc')
            ->get();

        // Kalkulasi penghasilan minggu ini
        $thisWeekRevenue = $thisWeekBookings
            ->where('status', 'completed') // hanya booking yang selesai
            ->sum(function ($booking) {
                $serviceIds = is_array($booking->service_ids)
                    ? $booking->service_ids
                    : json_decode($booking->service_ids, true);

                return Service::whereIn('id', $serviceIds)->sum('price');
            });


        // Jumlah semua layanan (hanya ditampilkan untuk admin)
        $servicesCount = Service::count();

        return view('dashboard', compact(
            'todayBookingsCount',
            'thisWeekBookingsCount',
            'todayBookings',
            'thisWeekRevenue',
            'servicesCount'
        ));
    }


    // --- CRUD Booking ---

    /**
     * Menampilkan daftar booking.
     */
    public function bookingsIndex(Request $request)
    {
        // Filter berdasarkan status jika ada
        $status = $request->query('status');
        $query = Booking::with('barber');

        if ($status && in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        // Urutkan berdasarkan tanggal dan jam terbaru
        $bookings = $query->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->paginate(10); // Paginate untuk performa

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Menampilkan detail booking.
     */
    public function bookingsShow(Booking $booking)
    {
        // Load relasi barber dan services
        $booking->load('barber');
        $services = Service::whereIn('id', $booking->service_ids)->get(); // Ambil layanan berdasarkan ID

        return view('bookings.show', compact('booking', 'services'));
    }

    /**
     * Mengubah status booking.
     */
    public function bookingsUpdateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Menghapus booking.
     */
    public function bookingsDestroy(Booking $booking)
    {
        // Hapus foto terkait jika ada
        if ($booking->photo_path) {
            Storage::disk('public')->delete($booking->photo_path);
        }
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dihapus.');
    }

    // --- CRUD Layanan (Services) ---

    /**
     * Menampilkan daftar layanan.
     */
    public function servicesIndex()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    /**
     * Menampilkan form tambah layanan baru.
     */
    public function servicesCreate()
    {
        return view('services.create');
    }

    /**
     * Menyimpan layanan baru.
     */
    public function servicesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'price' => 'required|numeric|min:0',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit layanan.
     */
    public function servicesEdit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Memperbarui layanan.
     */
    public function servicesUpdate(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $service->id,
            'price' => 'required|numeric|min:0',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Menghapus layanan.
     */
    public function servicesDestroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    // --- CRUD Barber (Barbers) ---

    /**
     * Menampilkan daftar barber.
     */
    public function barbersIndex()
    {
        $barbers = Barber::all();
        return view('barbers.index', compact('barbers'));
    }

    /**
     * Menampilkan form tambah barber baru.
     */
    public function barbersCreate()
    {
        return view('barbers.create');
    }

    /**
     * Menyimpan barber baru.
     */
    public function barbersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:barbers,name',
            'schedule' => 'nullable|string|max:1000',
        ]);

        Barber::create($request->all());

        return redirect()->route('barbers.index')->with('success', 'Barber berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit barber.
     */
    public function barbersEdit(Barber $barber)
    {
        return view('barbers.edit', compact('barber'));
    }

    /**
     * Memperbarui barber.
     */
    public function barbersUpdate(Request $request, Barber $barber)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:barbers,name,' . $barber->id,
            'schedule' => 'nullable|string|max:1000',
        ]);

        $barber->update($request->all());

        return redirect()->route('barbers.index')->with('success', 'Barber berhasil diperbarui.');
    }

    /**
     * Menghapus barber.
     */
    public function barbersDestroy(Barber $barber)
    {
        $barber->delete();
        return redirect()->route('barbers.index')->with('success', 'Barber berhasil dihapus.');
    }
}
