<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionRepository
{
    public static function getAll()
    {
        return Permission::all();
    }
}
