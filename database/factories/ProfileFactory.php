<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $authors = Author::all();
        return [
            'career' => $this->faker->word(),
            'biography' => $this->faker->text(150),
            'website' => $this->faker->domainName(),
            'email' => $this->faker->email(),
            'author_id' =>  $this->faker->unique()->numberBetween(1, $authors->count())
        ];
    }
}
