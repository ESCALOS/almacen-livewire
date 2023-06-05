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
            'name' => 'executive',
            'guard_name' => 'web',
        ]);

        $logistic = Role::create([
            'name' => 'logistic',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'requester',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'storekeeper',
            'guard_name' => 'web',
        ]);
        User::find(1)->assignRole($logistic);
    }
}
