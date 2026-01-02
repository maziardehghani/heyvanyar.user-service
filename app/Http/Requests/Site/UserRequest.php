<?php

namespace App\Http\Requests\Site;

use App\Models\User;

use Illuminate\Foundation\Http\FormRequest;


class UserRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            User::MELLI_CODE => ['required', 'string'],
            'card_number' => ['required', 'string', 'max:16', 'min:15'],
            'birth_date' => ['required', 'string', 'min:9'],
            User::CITY_ID => ['nullable', 'integer'],
        ];

    }
    // protected function passedValidation(): void
    // {
    //     $response = Http::withToken(env('ZIBAL_ACCESS_KEY'))->post('https://api.zibal.ir/v1/facility/cardToIban/', [
    //         'cardNumber' => $this->card_number,
    //     ]);

    //     if ($response->object()->result == 1)
    //         $this->merge([
    //             'full_name' => $response->object()->data->name,
    //             'shaba' => $response->object()->data->IBAN,
    //             'bank_name' => $response->object()->data->bankName
    //         ]);
    // }


}
