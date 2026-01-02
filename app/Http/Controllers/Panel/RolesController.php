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
use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use PhpParser\Node\Expr\Throw_;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->success(RoleRepository::getAll(), Response::HTTP_OK, 'لیست نقش ها با موفقیت دریافت شد');
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
        RoleRepository::store($request->validated());

        return response()->success('', Response::HTTP_CREATED, 'نقش با موفقیت ذخیره شد');
    }



    public function update(RoleRequest $request, Role $role): JsonResponse
    {

        RoleRepository::update($request->validated(), $role);

        return response()->success('', Response::HTTP_CREATED, 'نقش با موفقیت بروز رسانی شد');


    }



    public function delete(Role $role): JsonResponse
    {

        return response()->success(RoleRepository::delete($role), Response::HTTP_OK, 'نقش با موفقیت حذف شد');
    }


    public function assignRole(User $user, RoleRequest $request): JsonResponse
    {

        $user->assignRole(RoleRepository::getByName($request->role));
        return response()->success('', Response::HTTP_ACCEPTED, 'نقش مورد نظر به کاربر اعطا شد');
    }


    public function revokeRole(User $user, RoleRequest $request): JsonResponse
    {

        $user->removeRole(RoleRepository::getByName($request->role));
        return response()->success('', Response::HTTP_ACCEPTED, 'نقش مورد نظر از کاربر گرفته شد');

    }


    public function givePermission($role, PermissionRequest $request): JsonResponse
    {

        RoleRepository::givePermissionsToRole($role, $request->permissions);

        return response()->success('', Response::HTTP_ACCEPTED, 'مجوز مورد نظر به نقش داده شد');

    }



    public function revokePermission(Permission $permission, RoleRequest $request): JsonResponse
    {

        $role = RoleRepository::getByName($request->role);
        $role->revokePermissionTo($permission->name);

        return response()->success('', Response::HTTP_ACCEPTED, 'مجوز مورد نظر لغو شد');

    }

    public function role_permissions($role): JsonResponse
    {

        $permissions = RoleRepository::getPermissionsByRole($role);

        return response()->success(PermissionResource::collection($permissions), Response::HTTP_OK, 'لیست رول ها با موفقیت دریافت شد');
    }


}
