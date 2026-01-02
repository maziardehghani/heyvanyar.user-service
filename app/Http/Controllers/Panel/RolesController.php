<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\PermissionRequest;
use App\Http\Requests\Panel\RoleRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Repositories\RoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->success(RoleRepository::getAll());
    }


    public function authorize(): JsonResponse
    {
        $roles = Role::all();

        if(!auth()->user()->hasRole($roles))
        {
            throw new UnauthorizedException('Unauthorized');
        }

        return response()->success();
    }



    public function store(RoleRequest $request): JsonResponse
    {
        $role = RoleRepository::store($request->validated());

        return response()->success($role);
    }



    public function update(RoleRequest $request, Role $role): JsonResponse
    {

       $result = RoleRepository::update($request->validated(), $role);

        return response()->success($result, Response::HTTP_CREATED, 'نقش با موفقیت بروز رسانی شد');

    }



    public function delete(Role $role): JsonResponse
    {
        return response()->success(RoleRepository::delete($role));
    }


    public function assignRole(User $user, Request $request): JsonResponse
    {

       $result = $user->assignRole(RoleRepository::getByName($request->role));

        return response()->success($result);
    }


    public function revokeRole(User $user, Request $request): JsonResponse
    {

        $user->removeRole(RoleRepository::getByName($request->role));

        return response()->success('');

    }


    public function givePermission($role, PermissionRequest $request): JsonResponse
    {

        $result = RoleRepository::givePermissionsToRole($role, $request->permissions);

        return response()->success($result);

    }



    public function revokePermission(Permission $permission, RoleRequest $request): JsonResponse
    {
        $role = RoleRepository::getByName($request->role);
        $result = $role->revokePermissionTo($permission->name);

        return response()->success($result);

    }

    public function rolePermissions(Role $role): JsonResponse
    {

        $permissions = RoleRepository::getPermissionsByRole($role);

        return response()->success(PermissionResource::collection($permissions));
    }


}
