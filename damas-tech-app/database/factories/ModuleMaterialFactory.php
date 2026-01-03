<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModuleMaterial>
 */
class ModuleMaterialFactory extends Factory
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
            'type' => 'video',
            'external_link' => $this->faker->url(),
            'file_path' => null,
        ];
    }

    public function project(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'project',
            'external_link' => $this->faker->url(), // Repository link?
        ]);
    }
}
