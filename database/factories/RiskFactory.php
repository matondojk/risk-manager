<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Department;
use App\Models\User;

class RiskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'department_id' => Department::inRandomOrder()->first()->id ?? Department::factory(),
            'owner_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'process' => fake()->catchPhrase(),
            'objective' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'cause' => fake()->paragraph(),
            'consequence' => fake()->paragraph(),
            'origin' => fake()->randomElement(['Interno', 'Externo', 'Misto']),
            'inherent_probability' => fake()->numberBetween(1, 5),
            'inherent_impact' => fake()->numberBetween(1, 5),
            'residual_probability' => fake()->boolean(50) ? fake()->numberBetween(1, 5) : null,
            'residual_impact' => fake()->boolean(50) ? fake()->numberBetween(1, 5) : null,
            'status' => fake()->randomElement(['Identificado', 'Em Avaliação', 'Mitigado', 'Aceite']),
        ];
    }
}
