<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'slug' => $this->faker->slug(),
            'subtitle' => $this->faker->sentence(5),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(15, 300) * 100,
            'image' => 'https://via.placeholder.com/200x250'
        ];
    }
}
