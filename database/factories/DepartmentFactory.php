<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{

    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
