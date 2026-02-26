<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\UserFileRequest;
use App\Http\Requests\Site\UserRequest;
use App\Http\Resources\FileResource;
use App\Http\Resources\UserResource;

use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    public function profile(): JsonResponse
    {
        return response()->success(new UserResource(auth()->user()), Response::HTTP_CREATED, 'پروفایل کاربر با موفقیت دریافت شد');
    }

    public function update(UserRequest $request): JsonResponse
    {
        UserRepository::userUpdate($request, auth()->user());

        return response()->success(new UserResource(auth()->user()));
    }

    public function userBankAccounts(): JsonResponse
    {
        $bankAccounts = UserRepository::getUserBankAccounts();

        return response()->success($bankAccounts);
    }


}
