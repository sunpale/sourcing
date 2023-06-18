<?php

namespace App\Http\Requests\master_data;

use App\Rules\AlphaSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class MeasureRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'measure_name' => ['required',new AlphaSpaceRule(),'max:25']
        ];
        if(empty($this->input('number'))){
            $rules['kode'] = ['required','alpha','unique:measures,kode','max:3'];
        }else{
            if (strcmp($this->input('old_kode'),$this->input('kode'))==0){
                $rules['kode'] = ['required','alpha','max:3'];
            }else{
                $rules['kode'] = ['required','alpha','unique:measures,kode','max:3'];
            }
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
