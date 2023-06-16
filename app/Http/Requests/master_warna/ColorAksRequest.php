<?php

namespace App\Http\Requests\master_warna;

use App\Rules\AlphaNumericPunctRule;
use Illuminate\Foundation\Http\FormRequest;

class ColorAksRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'color_desc' => ['required',new AlphaNumericPunctRule(),'max:100'],
            'remarks' => [new AlphaNumericPunctRule(),'max:100','nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
