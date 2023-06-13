<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'Gerencia'
        ]);

        \App\Models\Category::factory(4)->create();

        \App\Models\MeasurementUnit::factory(4)->create();

        \App\Models\Product::factory(50)->create();

        User::create([
            'name' => 'Administador',
            'email' => 'stornblood6969@gmail.com',
            'email_verified_at' => now(),
            'department_id' => 1,
            'is_admin' => true,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);

        $this->call([
            RoleSeeder::class,
        ]);
    }
}
