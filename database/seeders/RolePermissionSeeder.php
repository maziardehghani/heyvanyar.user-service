<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RolePermissionSeeder extends Seeder
{

    public function run(): void
    {

        $role = Role::create([
           'name' => 'management'
        ]);

        $permissions = Permission::query()->get();


        $role->givePermissionTo($permissions);


        $user = User::query()->where('mobile', '9931591988')->first();

        $user->assignRole($role);

    }
}
