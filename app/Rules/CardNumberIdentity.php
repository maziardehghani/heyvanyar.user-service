<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class CardNumberIdentity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::withToken(env('ZIBAL_ACCESS_KEY'))->post('https://api.zibal.ir/v1/facility/checkCardWithNationalCode', [
            'cardNumber' => $value,
            'nationalCode' => isset(auth()->user()->melli_code) ? auth()->user()->melli_code : request()->melli_code,
            'birthDate' => request()->birth_date,
        ]);

        if ($response->object()->result != 1)
            $fail($response->object()->message);

        elseif (!$response->object()->data->matched)
            $fail('شماره کارت وارد شده با کدملی شما تطابق ندارد');


    }
}
