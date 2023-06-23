<?php

namespace App\Http\Requests\inventory\warehouse;

use App\Rules\AlphaNumericPunctRule;
use App\Rules\AlphaNumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'location' => ['required',new AlphaNumericSpaceRule(),'max:50'],
            'remarks' => ['nullable',new AlphaNumericPunctRule(),'max:255']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
