<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'brand' => \Illuminate\Support\Str::random(6),
            'model' => \Illuminate\Support\Str::random(4),
            'price' => rand(100, 1000),

//            'brand' => $this->faker->name(),
//            'model' => $this->faker->name(),
//            'price' => rand(100, 1000),
        ];
    }
}
