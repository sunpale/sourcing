<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumericPunctRule implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value): bool
    {
        return preg_match('/\A[\r\n\w ~!#$%\/\\&\*\-+=|:.,\()]+\z/i', $value);
    }

    public function message(): string
    {
        return 'The :attribute field may only contain alphanumeric characters, spaces, and the ~ character! # $% & * - _ + = | :. .';
    }
}
