<?php

namespace App\Http\Requests;

use App\Rules\AlpaSpaceRule;
use App\Rules\AlphaNumericPunctRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name'      => ['required',new AlpaSpaceRule(),'max:30'],
            'type'      => 'required',
            'address'   => [new AlphaNumericPunctRule(),'max:255','nullable'],
            'country'   => [new AlpaSpaceRule(),'max:30','nullable'],
            'pic'       => ['required',new AlpaSpaceRule(),'max:30'],
            'phone'     => 'required|numeric|max_digits:16',
            'email'     => 'email|max:50|nullable'
        ];
        if ($this->input('type')==='AKS'){
            $rules['product_group_id'] = 'required|numeric|min:1';
        }
        return $rules;
    }

    public function getValidatorInstance(): Validator
    {
        $this->sanitizePhoneNumber();
        return parent::getValidatorInstance();
    }

    protected function sanitizePhoneNumber(){
        if($this->request->has('phone')){
            $this->merge(['phone' => str_replace(' ','',$this->request->get('phone'))]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
