<?php

namespace App\Http\Requests\master_data;

use App\Rules\AlphaSpaceRule;
use App\Rules\AlphaNumericPunctRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name'      => ['required',new AlphaSpaceRule(),'max:30'],
            'product_group_id' => 'required|numeric|min:1',
            'type'      => 'required',
            'address'   => [new AlphaNumericPunctRule(),'max:255','nullable'],
            'country'   => [new AlphaSpaceRule(),'max:30','nullable'],
            'pic'       => ['required',new AlphaSpaceRule(),'max:30'],
            'phone'     => 'required|numeric|max_digits:16',
            'email'     => 'email|max:50|nullable'
        ];
        return $rules;
    }

    public function getValidatorInstance(): Validator
    {
        $this->sanitizePhoneNumber();
        return parent::getValidatorInstance();
    }

    protected function sanitizePhoneNumber(): void
    {
        if($this->request->has('phone')){
            $this->merge(['phone' => str_replace(' ','',$this->request->get('phone'))]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
