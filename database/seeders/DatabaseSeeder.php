<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        /*\App\Models\Department::factory()->create([
            'name' => 'Gerencia'
        ]);

        \App\Models\Category::factory(4)->create();

        \App\Models\MeasurementUnit::factory(4)->create();
*/
        \App\Models\Product::factory(50)->create();

        /*\App\Models\User::factory()->create([
            'name' => 'Administrador',
            'email' => 'stornblood6969@gmail.com',
            'department_id' => 1,
        ]);

        $this->call([
            RoleSeeder::class,
        ]);*/
    }
}
