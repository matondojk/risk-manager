<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Risk;
use App\Models\User;

class ActionPlanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'risk_id' => Risk::inRandomOrder()->first()->id ?? Risk::factory(),
            'who_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'what' => fake()->sentence(4),
            'why' => fake()->sentence(6),
            'where' => fake()->city(),
            'when_date' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'how' => fake()->paragraph(),
            'how_much' => fake()->randomFloat(2, 0, 50000),
            'status' => fake()->randomElement(['Não Iniciado', 'Em Andamento', 'Concluído', 'Atrasado']),
        ];
    }
}
