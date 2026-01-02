<?php

namespace App\Http\Requests\Panel;

use App\Models\City;
use App\Models\User;
use App\Rules\ValidMelliCode;
use App\Rules\ValidMobileRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => ['nullable', 'string', 'max:50'],

            'bank_accounts_info' => ['nullable', 'array'],

            'melli_code' => ['nullable', new ValidMelliCode()],

            'mobile' => [
                'required',
                Rule::unique('users', 'mobile'),
                new ValidMobileRule()
            ],

            'password' => ['nullable', 'string', 'min:8'],

            'status' => [
                'nullable',
                Rule::in(User::$statuses),
            ],

            'city_id' => ['nullable', 'integer'],

            'credit' => ['nullable', 'integer', 'min:0'],

            'birth_date' => [
                'nullable',
                'regex:/^\d{4}\/\d{2}\/\d{2}$/',
            ],
        ];
    }


}
