<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Area;

class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'area_id' => Area::factory(),
            'name' => fake()->unique()->word(),
        ];
    }
}
