<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = UserRepository::getAll();

        return response()->success(UserResource::collection($users));
    }


    public function show($id): JsonResponse
    {
        $user = UserRepository::getById($id);

        return response()->success(new UserResource($user));
    }


    public function getByMobile($mobile): JsonResponse
    {
        $user = UserRepository::getByMobile($mobile);

        return response()->success($user);
    }


    public function update(UserRequest $request, User $user): JsonResponse
    {
        UserRepository::userUpdate($request, $user);

        return response()->success();
    }

    public function admins(): JsonResponse
    {
        $users = UserRepository::userHasRole();

        return response()->success(UserResource::collection($users->load('roles')));
    }

    public function usersList(Request $request)
    {
        $users = UserRepository::getUsersByIds($request->ids);

        return response()->success(UserResource::collection($users->load('roles')));

    }
}
