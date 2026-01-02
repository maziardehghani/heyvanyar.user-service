<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\ValidMobileRule;
use App\Events\VerificationEvent;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Site\AuthRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CodeService\VerifyCodeService;


class AuthController extends Controller
{
    public function register(AuthRequest $request): JsonResponse
    {
        $user = User::query()->firstOrCreate(
            [
                User::MOBILE => ltrim($request->input('mobile'), '0'),
            ]);


        Gate::allowIf(!VerifyCodeService::get($user->id), 'ما قبلا یک کد تایید برای شما فرستاده ایم', Response::HTTP_METHOD_NOT_ALLOWED);

        event(new VerificationEvent($user));

        return response()->success(VerifyCodeService::get($user->id), Response::HTTP_OK, " پیام حاوی کد یکبار مصرف به شماره تلفن " . $request->mobile . " فرستاده شد ");

    }

    public function verify(AuthRequest $request): JsonResponse
    {
        $user = User::query()->firstWhere(User::MOBILE, ltrim($request->input('mobile'), '0'));


        Gate::allowIf(isset($user), 'کاربر یافت نشد');

        Gate::allowIf(VerifyCodeService::check($request->code, $user->id), " کد فرستاده شده معتبر نمیباشد");


        if (!$user->hasVerified()) $user->verify();

        $token = $user->createToken('User')->plainTextToken;

        return response()->success([new UserResource($user), 'token' => $token], Response::HTTP_CREATED, 'کاربر با موفقیت تایید شد');
    }

    public function check_code(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            User::MOBILE => ['required', 'string', 'max:14', 'min:9', new ValidMobileRule()],
            'code' => VerifyCodeService::getRule(),
        ]);

        if ($validate->fails()) {
            return response()->error(401, $validate->messages());
        }

        $mobile = ltrim($request->input('mobile'), '0');
        $user = User::query()->where(User::MOBILE, $mobile)->first();

        Gate::allowIf(isset($user), 'کاربری با این شماره تلفن وجود ندارد');

        Gate::allowIf(VerifyCodeService::get($user->id) == $request->code, " کد فرستاده شده معتبر نمیباشد");

        $token = $user->createToken('User')->plainTextToken;

        return response()->success([
            "token" => $token,
            "user" => [
                'id' => $user->id,
                'name' => $user->full_name,
                'mobile' => $user->mobile,
            ]
        ], Response::HTTP_OK, 'کد فرستاده شده تایید شد');

    }

    public function user(): JsonResponse
    {
        $user = auth()->user();
        return response()->success(new UserResource($user), 200, 'کاربر مورد نطر یافت شد');
    }


    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->success('', Response::HTTP_OK, 'کاربر خارج شد');
    }
}
