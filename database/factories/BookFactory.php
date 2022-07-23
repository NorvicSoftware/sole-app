<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'subtitle' => $this->faker->text(75),
            'language' => $this->faker->randomElement(['Español', 'Ingles']),
            'page' => $this->faker->numberBetween(50, 1000),
            'published' => $this->faker->date(),
            'description' => $this->faker->text(1000),
            'genre_id' => Genre::all()->random()->id,
            'publisher_id' => Publisher::all()->random()->id,
        ];
    }
}
