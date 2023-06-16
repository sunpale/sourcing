<?php

namespace App\Http\Requests\master_material;

use App\Rules\AlphaNumericPunctRule;
use App\Rules\AlphaSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductGroupRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'group' => ['required',new AlphaSpaceRule(),'max:25'],
            'remarks' => [new AlphaNumericPunctRule(),'max:100','nullable'],
            'type' => 'required'
        ];
        if(empty($this->input('number'))){
            $rules['kode'] = ['required','alpha','unique:product_groups,kode'];
        }else{
            if (strcmp($this->input('old_kode'),$this->input('kode'))==0){
                $rules['kode'] = ['required','alpha_num'];
            }else{
                $rules['kode'] = ['required','alpha_num','unique:product_groups,kode'];
            }
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
