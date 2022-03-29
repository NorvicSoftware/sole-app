<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => 'image/' . $this->faker->image('storage/app/image', 640,480, null, false),
            'imageable_id' => $this->faker->randomElement([1, 2, 3, 4]),
            'imageable_type' => $this->faker->randomElement(['App/Models/Author', 'App/Models/Book']),
        ];
    }
}
