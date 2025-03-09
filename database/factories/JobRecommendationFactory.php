<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobRecommendation>
 */
class JobRecommendationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'company' => fake()->company(),
            'location' => fake()->randomElement(['Remote', 'San Francisco', 'New York', 'London', 'Hybrid']),
            'employment_type' => fake()->randomElement(['Full-time', 'Part-time', 'Contract', 'Hybrid']),
            'skills' => json_encode(fake()->randomElements(['React', 'Node.js', 'AWS', 'Docker', 'Laravel', 'Vue.js', 'Python'], rand(2, 4))),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
