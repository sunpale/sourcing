<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class FabricRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'prefix' => 'required|alpha|alpha_num',
            'description' => ['required',new AlphaNumericSpaceRule()]
        ];
        if(empty($this->input('number'))){
            $rules['kode'] = ['required','alpha_num','unique:fabrics,kode'];
        }else{
            if (strcmp($this->input('old_kode'),$this->input('kode'))==0){
                $rules['kode'] = ['required','alpha_num'];
            }else{
                $rules['kode'] = ['required','alpha_num','unique:fabrics,kode'];
            }
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
