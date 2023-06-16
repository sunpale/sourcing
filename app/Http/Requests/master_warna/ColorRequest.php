<?php

namespace App\Http\Requests\master_warna;

use App\Rules\AlphaSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'description' => ['required',new AlphaSpaceRule(),'max:25']
        ];
        if(empty($this->input('number'))){
            $rules['kode'] = ['required','alpha','unique:colors,kode'];
        }else{
            if (strcmp($this->input('old_kode'),$this->input('kode'))==0){
                $rules['kode'] = ['required','alpha'];
            }else{
                $rules['kode'] = ['required','alpha','unique:colors,kode'];
            }
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
