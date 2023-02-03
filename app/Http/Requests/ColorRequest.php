<?php

namespace App\Http\Requests;

use App\Rules\AlpaSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'description' => ['required',new AlpaSpaceRule(),'max:25']
        ];
        if(empty($this->input('number'))){
            $rules['kode'] = ['required','alpha','unique:colors,kode'];
        }else{
            if (strcmp($this->input('old_kode'),$this->input('kode'))==0){
                $rules['kode'] = ['required','alpha_num'];
            }else{
                $rules['kode'] = ['required','alpha_num','unique:colors,kode'];
            }
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
