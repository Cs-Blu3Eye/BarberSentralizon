<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel untuk data booking
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name'); // Nama lengkap pelanggan
            $table->string('customer_whatsapp'); // Nomor WhatsApp pelanggan
            $table->date('booking_date'); // Tanggal booking
            $table->time('booking_time'); // Jam booking
            $table->json('service_ids'); // ID layanan yang dipilih (disimpan sebagai JSON array)
            $table->foreignId('barber_id')->constrained('barbers')->onDelete('cascade'); // ID barber yang dipilih
            $table->string('photo_path')->nullable(); // Path foto yang diupload
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending'); // Status booking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
