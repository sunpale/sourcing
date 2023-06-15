<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphaNumericPunctRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/\A[\r\n\w ~!#$%\/\\&\*\-+=|:.,\()]+\z/i', $value)){
            $fail('The :attribute field may only contain alphanumeric characters, spaces, and the ~ character! # $% & * - _ + = | :. .');
        }
    }
}
