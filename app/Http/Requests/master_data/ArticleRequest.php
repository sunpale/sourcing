<?php

namespace App\Http\Requests\master_data;

use App\Rules\AlphaSpaceRule;
use App\Rules\AlphaNumericPunctRule;
use App\Rules\AlphaNumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required',new AlphaNumericSpaceRule(),'max:50'],
            'pantone_id' => ['required', 'integer'],
            'brand_id' => ['required', 'integer'],
            'modul' => ['required',new AlphaNumericPunctRule(),'max:25'],
            'designer' => ['required',new AlphaSpaceRule(),'max:50'],
            'img_file' => 'image|mimes:jpg,jpeg,png|max:1024|nullable'
        ];
        if (empty($this->input('number'))){
            $rules['kode'] = ['required','unique:articles,kode','numeric','max_digits:16'];
        }else{
            if (strcmp($this->input('old_kode'),$this->input('kode'))==0){
                $rules['kode'] = ['required','numeric','max_digits:16'];
            }else{
                $rules['kode'] = ['required','unique:articles,kode','numeric','max_digits:16'];
            }

        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
