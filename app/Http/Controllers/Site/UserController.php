<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\UserFileRequest;
use App\Http\Requests\Site\UserRequest;
use App\Http\Resources\AdResource;
use App\Http\Resources\ContractListResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\SettlementResource;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;

use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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






    public function store_file(UserFileRequest $request): JsonResponse
    {

        $file_type = $this->fileRepo->get_type($request->model_type);
        $file = $this->fileRepo->store_user_files($request, $file_type);

        return $this->successResponse(FileResource::collection($file), Response::HTTP_OK, 'فایل با موفقیت ذخیره شد');
    }

    public function userFiles(): JsonResponse
    {
        $files = $this->fileRepo->get_user_files();

        return $this->successResponse(FileResource::collection($files), Response::HTTP_OK, 'لیست فایل های کاربر ارسال شد');
    }


}
l