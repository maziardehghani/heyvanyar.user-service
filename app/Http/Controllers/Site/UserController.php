<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\UserFileRequest;
use App\Http\Requests\Site\UserRequest;
use App\Http\Resources\AdResource;
use App\Http\Resources\ContractListResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\SettlementResource;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Repositories\AdsRepository;
use App\Repositories\ContractRepository;
use App\Repositories\FileRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\SettlementRepository;
use App\Repositories\TicketRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Traits\ApiResponse;
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


    

    public function userPayments(): JsonResponse
    {
        $payments = $this->paymentRepo->getUserPayments(auth()->id());

        return $this->successResponse(PaymentResource::collection($payments->load('contract')), Response::HTTP_OK, 'لیست برداخت های کاربر دریافت شد');
    }

    public function userTickets(): JsonResponse
    {
        $tickets = $this->ticketRepo->getUserTickets(auth()->id());
        return $this->paginateResponse($tickets, ['Contract'], TicketResource::class, 'تیکت ها با موفقیت دریافت شدند');
    }

    public function user_contracts(Request $request): JsonResponse
    {
        $contracts = $this->contractRepo->get_user_contracts(auth()->user(), $request->input('status'));

        Gate::allowIf(!is_null($contracts), 'هیچ قرار دادی یافت نشد');

        return $this->successResponse(
            [
                'contracts' => ContractResource::collection($contracts
                    ->load('question')
                    ->load('user')
                    ->load('animal_category')
                ),
            ], Response::HTTP_OK, 'قرارداد های کاربر فعلی با موفقیت دریافت شد');
    }

    public function user_contract_list(): JsonResponse
    {
        $contracts = auth()->user()->contracts;
        return $this->successResponse(ContractListResource::collection($contracts), Response::HTTP_OK, 'قرارداد های کاربر فعلی با موفقیت دریافت شد');
    }

    public function userTransactions(): JsonResponse
    {
        $transactions = $this->transactionRepo->getUserTransactions(auth()->id());

        return $this->successResponse(TransactionResource::collection($transactions->load('contract')), Response::HTTP_OK, 'تراکنش های کاربر با موفقیت دریافت شد');
    }

    public function user_inventory(): JsonResponse
    {
        $mount = $this->transactionRepo->getUserCredit();
        return $this->successResponse(['mount' => $mount], Response::HTTP_OK, 'موجودی کیف بول کاربر دریافت شد');
    }

    public function userSettlements(): JsonResponse
    {
        return $this->successResponse(SettlementResource::collection($this->settlementRepo->userSettlements()), Response::HTTP_OK, 'لیست تسویه های کاربر دریافت شد');
    }

    public function ads(): JsonResponse
    {
        $ads = auth()->user()->ads()->latest()->paginate();

        return $this->paginateResponse($ads, ['animal_category', 'files'], AdResource::class, 'آگهی های کاربر با موفقیت دریافت شدند');
    }
}
