<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumericSpaceRule implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value): bool
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }

        return preg_match('/^[\pL\pM\pN ]+$/u', $value) > 0;
    }

    public function message(): string
    {
        return 'The :attribute field may only contain alphanumeric characters and spaces.';
    }
}
