<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(1000),
            'writing_date' => $this->faker->date(),
            'noteable_id' => $this->faker->randomElement([1, 2, 3, 4]),
            'noteable_type' => $this->faker->randomElement(['App/Models/Author', 'App/Models/Book']),
            'user_id' => User::all()->random()->id,
        ];
    }
}
