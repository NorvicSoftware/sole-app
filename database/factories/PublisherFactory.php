<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publisher>
 */
class PublisherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'country' => $this->faker->country(),
            'website' => $this->faker->domainName(),
            'email' => $this->faker->email(),
            'description' => $this->faker->text(250),
        ];
    }
}
