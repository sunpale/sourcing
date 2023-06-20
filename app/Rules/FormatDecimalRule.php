<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FormatDecimalRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^-?(?:\d+|\d{1,3}(?:.\d{3})+)?$/',$value)){
            $fail('The :attribute field using an invalid format');
        }
    }
}
