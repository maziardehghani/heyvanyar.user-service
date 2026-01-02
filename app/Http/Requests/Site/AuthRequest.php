<?php

namespace App\Http\Requests\Site;

use App\Models\User;
use App\Rules\ValidMobileRule;
use App\Services\CodeService\VerifyCodeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the User is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rule = [
            User::MOBILE => ['required', 'string', 'max:11', 'min:9', new ValidMobileRule()],
//            User::PASSWORD => ['required', 'string', 'min:8' ]
        ];


        if (request()->route()->getName() == 'verify')
        {
            $rule = [
                User::MOBILE => ['required', 'string', 'max:11', 'min:9', new ValidMobileRule()],
                'code' => VerifyCodeService::getRule(),
            ];
        }


//        if (request()->route()->getName() == 'login')
//        {
//            $rule = [
//                User::MOBILE => ['required', 'string', 'max:14', 'min:9', new ValidMobileRule()],
//                User::PASSWORD => ['required' , 'string' , 'min:8'],
//            ];
//        }

//        if(request()->route()->getName() == 'change_password')
//        {
//            $rule = [
//                User::PASSWORD => ['required', 'string', 'min:8', 'confirmed']
//            ];
//        }

        return $rule;
    }
}
