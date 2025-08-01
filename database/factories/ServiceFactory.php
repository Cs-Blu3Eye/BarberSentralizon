<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Potong Rambut', 'Cuci Rambut', 'Shaving', 'Hair Spa', 'Facial']),
            'price' => $this->faker->randomFloat(2, 15000, 75000),
        ];
    }
}
