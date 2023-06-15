<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'ejecutivo',
            'guard_name' => 'web',
        ]);

        $logistic = Role::create([
            'name' => 'logistica',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'solicitante',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'almacenero',
            'guard_name' => 'web',
        ]);
        User::find(1)->assignRole($logistic);
    }
}
