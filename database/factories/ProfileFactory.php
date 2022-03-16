<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'image' => $this->faker->name(),
            'file_type' => $this->faker->name(),
            'message' => $this->faker->text(),
            'status' => $this->faker->boolean(),
            'fb_id' => Str::random(10),
            'fb_post_id' => Str::random(10),
        ];
    }
}
