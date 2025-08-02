<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'nama_menu' => $this->faker->words(2, true),
                'deskripsi' => $this->faker->sentence(),
                'harga' => $this->faker->numberBetween(15000, 100000),
                'kategori' => $this->faker->randomElement(['Makanan', 'Minuman', 'Snack']),
            ];
    }
}
