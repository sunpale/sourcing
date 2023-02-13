<?php

namespace App\Http\Requests;

use App\Rules\AlpaSpaceRule;
use App\Rules\AlphaNumericPunctRule;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required',new AlpaSpaceRule(),'max:30'],
            'type' => 'required',
            'address' => [new AlphaNumericPunctRule(),'max:255','nullable']
        ];
        if ($this->input('type')==='AKS'){
            $rules['product_group_id'] = 'required|numeric|min:1';
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
