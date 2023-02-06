<?php

namespace App\Http\Requests;

use App\Rules\AlpaSpaceRule;
use App\Rules\AlphaNumericPunctRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'group' => ['required',new AlpaSpaceRule(),'max:25'],
            'remarks' => [new AlphaNumericPunctRule(),'max:100','nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
