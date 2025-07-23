<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController as AdminController;
use Illuminate\Support\Facades\Route;

// --- Rute Frontend (Booking Tanpa Login) ---
Route::get('/', [BookingController::class, 'index'])->name('booking.form');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Admin-only
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.admin');

    // CRUD Booking
    Route::get('/admin/bookings', [AdminController::class, 'bookingsIndex'])->name('admin.bookings.index');
    Route::get('/admin/bookings/{booking}', [AdminController::class, 'bookingsShow'])->name('admin.bookings.show');
    Route::put('/admin/bookings/{booking}/status', [AdminController::class, 'bookingsUpdateStatus'])->name('admin.bookings.updateStatus');
    Route::delete('/admin/bookings/{booking}', [AdminController::class, 'bookingsDestroy'])->name('admin.bookings.destroy');

    // CRUD Layanan (Services)
    Route::get('/services', [AdminController::class, 'servicesIndex'])->name('services.index');
    Route::get('/services/create', [AdminController::class, 'servicesCreate'])->name('services.create');
    Route::post('/services', [AdminController::class, 'servicesStore'])->name('services.store');
    Route::get('/services/{service}/edit', [AdminController::class, 'servicesEdit'])->name('services.edit');
    Route::put('/services/{service}', [AdminController::class, 'servicesUpdate'])->name('services.update');
    Route::delete('/services/{service}', [AdminController::class, 'servicesDestroy'])->name('services.destroy');

    // CRUD Barberman (Barbers)
    Route::get('/barbers', [AdminController::class, 'barbersIndex'])->name('barbers.index');
    Route::get('/barbers/create', [AdminController::class, 'barbersCreate'])->name('barbers.create');
    Route::post('/barbers', [AdminController::class, 'barbersStore'])->name('barbers.store');
    Route::get('/barbers/{barber}/edit', [AdminController::class, 'barbersEdit'])->name('barbers.edit');
    Route::put('/barbers/{barber}', [AdminController::class, 'barbersUpdate'])->name('barbers.update');
    Route::delete('/barbers/{barber}', [AdminController::class, 'barbersDestroy'])->name('barbers.destroy');

});

// Barber-only
Route::middleware('auth', 'role:barber')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD Booking
    Route::get('/bookings', [AdminController::class, 'bookingsIndex'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminController::class, 'bookingsShow'])->name('bookings.show');
    Route::put('/bookings/{booking}/status', [AdminController::class, 'bookingsUpdateStatus'])->name('bookings.updateStatus');
    Route::delete('/bookings/{booking}', [AdminController::class, 'bookingsDestroy'])->name('bookings.destroy');

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
