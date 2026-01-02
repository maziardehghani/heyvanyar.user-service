<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class MelliCodeIdentity implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (isset($value) && !isset(auth()->user()->melli_code))
        {
            $response = Http::withToken(env('ZIBAL_ACCESS_KEY'))->post('https://api.zibal.ir/v1/facility/shahkarInquiry', [
                'mobile' => auth()->user()->mobile,
                'nationalCode' => $value
            ]);

            if ($response->object()->result != 1)
                $fail($response->object()->message);

            elseif (!isset($response->object()->data->matched) || !$response->object()->data->matched)
                $fail('کد ملی وارد شده با شماره تلفن شما تطابق ندارد');

        }
    }

}
