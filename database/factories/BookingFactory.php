<?php

namespace Database\Factories;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Booking::class;

    public function definition(): array
    {
        $barber = Barber::inRandomOrder()->first() ?? Barber::factory()->create();
        $services = Service::inRandomOrder()->take(rand(1, 3))->pluck('id');

        return [
            'customer_name' => $this->faker->name(),
            'customer_whatsapp' => '08' . $this->faker->randomNumber(9, true),
            'booking_date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
            'booking_time' => $this->faker->time('H:i'),
            'service_ids' => $services->values(),
            'barber_id' => $barber->id,
            'photo_path' => null,
            'notes' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'completed']),
        ];
    }
}
