<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPasswordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!preg_match('/^(?=.*[A-Z])(?=.*[@#$]).{8,}$/' , $value)){
            $fail(' پسورد حداقل ۸ کاراکتر و شامل حداقل یک حرف بزرگ و یک کاراکتر @ # $ ');
        }
    }
}
