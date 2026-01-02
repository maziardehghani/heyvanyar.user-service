<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository
{
    public static function getAll()
    {
        return Role::query()->get();
    }


    public static function getByName($role): object
    {
        return Role::query()->where('name', $role)->firstOrFail();
    }

    public static function get(int $id): object
    {
        return Role::query()->findOrFail($id);
    }


    public static function store(array $data): object
    {
        return Role::query()->create([
            'name' => $data['role'],
            'guard_name' => 'api'
        ]);
    }

    public static function update(array $data, object $model): bool
    {
        return $model->update([
            Role::NAME => $data['role']
        ]);
    }

    public static function givePermissionsToRole($role, $permissions): void
    {
        $role = self::get($role);

        $role->syncPermissions($permissions);
    }

    public static function getPermissionsByRole($role): object
    {
        $role =self::get($role);

        return $role->permissions;
    }
}
