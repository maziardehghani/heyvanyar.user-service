<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (\App\Models\Permission::$permissions as $permission)
        {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }

    }
}
