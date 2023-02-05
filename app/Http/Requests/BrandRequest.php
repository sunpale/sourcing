<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'brand' => ['required',new AlphaNumericSpaceRule(),'max:25']
        ];
        if(empty($this->input('number'))){
            $rules['kode'] = ['required','numeric','unique:brands,kode','max_digits:2','min_digits:2'];
        }else{
            if (strcmp($this->input('old_kode'),$this->input('kode'))==0){
                $rules['kode'] = ['required','numeric','max_digits:2','min_digits:2'];
            }else{
                $rules['kode'] = ['required','numeric','unique:brands,kode','max_digits:2','min_digits:2'];
            }
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
