<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlpaSpaceRule implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value): bool
    {
        return is_string($value) && preg_match('/\A[A-Z ]+\z/i', $value);
    }

    public function message(): string
    {
        return 'The :attribute field may only contain alphabetical characters and spaces.';
    }
}
