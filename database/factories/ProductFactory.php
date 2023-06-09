<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\MeasurementUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->lexify('??????'),
            'description' => $this->faker->text(50),
            'category_id' => Category::all()->random()->id,
            'measurement_unit_id' => MeasurementUnit::all()->random()->id
        ];
    }
}
