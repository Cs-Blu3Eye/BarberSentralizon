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
        // Tabel untuk layanan barbershop (misal: Potong Rambut, Cuci Rambut, Shaving)
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama layanan
            $table->decimal('price', 8, 2); // Harga layanan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
