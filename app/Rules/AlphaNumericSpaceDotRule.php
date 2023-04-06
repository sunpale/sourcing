<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumericSpaceDotRule implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value): bool
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }

        return preg_match('/^[a-zA-Z0-9\s.]+$/', $value);
    }

    public function message(): string
    {
        return 'The :attribute field may only contain alphanumeric characters, spaces, and dot';
    }
}
