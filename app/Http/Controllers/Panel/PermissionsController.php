<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

use App\Repositories\PermissionRepository;
use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use App\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{

    public function index(): JsonResponse
    {
        $permissions = PermissionRepository::getAll();

        return response()->success($permissions );
    }


    public function show(Permission $permission): JsonResponse
    {
        return response()->success($permission);
    }


}
