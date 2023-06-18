<?php

namespace App\Http\Requests\master_data;

use App\Rules\AlphaNumericPunctRule;
use App\Rules\AlphaNumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'size' => ['required',new AlphaNumericSpaceRule(),'max:15'],
            'remarks' => [new AlphaNumericPunctRule(),'max:255','nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
