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
    use ApiResponse;

    private object $PermissionRepo;

    public function __construct(PermissionRepository $PermissionRepo)
    {
        $this->PermissionRepo = $PermissionRepo;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        $this->authorize('index', Permission::class);
        return $this->successResponse($this->PermissionRepo->getAll(), Response::HTTP_OK, 'لیست مجوز ها با موفقیت دریافت شد');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Permission $permission): JsonResponse
    {
        $this->authorize('show', Permission::class);

        return $this->successResponse($permission, Response::HTTP_OK, 'نقش مورد نظر یافت شد');
    }


}
