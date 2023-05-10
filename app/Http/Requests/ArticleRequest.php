<?php

namespace App\Http\Requests;

use App\Rules\AlpaSpaceRule;
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
            'designer' => ['required',new AlpaSpaceRule(),'max:50'],
            'img_file' => 'image|mimes:jpg,jpeg,png|max:1024|nullable'
        ];
        if (empty($this->input('number'))){
            $rules['kode'] = ['required','unique:articles,kode','numeric','max_digits:16'];
        }else{
            $rules['kode'] = ['required','numeric','max_digits:16'];
        }
        return $rules;
    }
}
