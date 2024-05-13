<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Posts>
 */
class PostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $title = $faker->sentence(20);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'image' => 'https://picsum.photos/id/' . $faker->numberBetween(1, 100) . '/200/100',
            'description' => $faker->paragraphs(3, true),
        ];
    }
}
