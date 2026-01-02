<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

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
}
