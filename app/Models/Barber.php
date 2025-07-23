<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'schedule',
    ];

    /**
     * Mendapatkan booking yang terkait dengan barber ini.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
