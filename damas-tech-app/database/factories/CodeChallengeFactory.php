<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CodeChallenge>
 */
class CodeChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_id' => Module::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'language' => 'python',
            'initial_code' => "print('Hello')",
            'expected_output' => "Hello\n",
            'difficulty' => 'easy',
            'test_cases' => [],
        ];
    }
}
