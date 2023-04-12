<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumericPunctRule;
use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'size' => ['required','alpha_num:ascii','max:15'],
            'remarks' => [new AlphaNumericPunctRule(),'max:255','nullable'],
        ];
    }
}
