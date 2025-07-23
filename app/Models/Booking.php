<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'customer_name',
        'customer_whatsapp',
        'booking_date',
        'booking_time',
        'service_ids',
        'barber_id',
        'photo_path',
        'notes',
        'status',
    ];

    // Casting atribut ke tipe data tertentu
    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime', // Menggunakan datetime untuk kemudahan format
        'service_ids' => 'array', // Mengubah kolom service_ids menjadi array
    ];

    /**
     * Mendapatkan barber yang terkait dengan booking ini.
     */
    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    /**
     * Mendapatkan layanan yang terkait dengan booking ini.
     * Karena service_ids disimpan sebagai JSON array, kita perlu relasi many-to-many secara manual
     * atau mengambil layanan berdasarkan ID.
     */
    public function services()
    {
        // Mengambil layanan berdasarkan ID yang tersimpan di service_ids
        return Service::whereIn('id', $this->service_ids)->get();
    }
}
