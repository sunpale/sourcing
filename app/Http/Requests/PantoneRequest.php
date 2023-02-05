<?php

namespace App\Http\Requests;

use App\Rules\AlpaSpaceRule;
use App\Rules\AlphaNumericPunctRule;
use Illuminate\Foundation\Http\FormRequest;

class PantoneRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'pantone' => ['required',new AlpaSpaceRule(),'max:50']
        ];
        if(empty($this->input('number'))){
            $rules['kode'] = ['required',new AlphaNumericPunctRule(),'unique:pantones,kode'];
        }else{
            if (strcmp($this->input('old_kode'),$this->input('kode'))==0){
                $rules['kode'] = ['required',new AlphaNumericPunctRule(),'max:12'];
            }else{
                $rules['kode'] = ['required',new AlphaNumericPunctRule(),'unique:pantones,kode','max:12'];
            }
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
