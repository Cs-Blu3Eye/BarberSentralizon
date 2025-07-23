<?php

namespace Database\Factories;
use App\Models\Barber;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barber>
 */
class BarberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Barber::class;
    protected $user = User::class;
    public function definition(): array
    {
         return [
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'schedule' => json_encode([
                'monday' => '09:00-17:00',
                'tuesday' => '09:00-17:00',
                'wednesday' => '09:00-17:00',
                'thursday' => '09:00-17:00',
                'friday' => '09:00-17:00',
                'saturday' => '10:00-16:00',
                'sunday' => 'off',
            ]),
        ];
    }
}
