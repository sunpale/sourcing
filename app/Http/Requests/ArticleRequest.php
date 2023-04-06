<?php

namespace App\Http\Requests;

use App\Rules\AlpaSpaceRule;
use App\Rules\AlphaNumericPunctRule;
use App\Rules\AlphaNumericSpaceDotRule;
use App\Rules\AlphaNumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'kode' => ['required',new AlphaNumericSpaceDotRule(),'max:16'],
            'name' => ['required',new AlphaNumericSpaceRule(),'max:50'],
            'pantone_id' => ['required', 'integer'],
            'brand_id' => ['required', 'integer'],
            'modul' => ['required',new AlphaNumericPunctRule(),'max:25'],
            'designer' => ['required',new AlpaSpaceRule(),'max:50'],
            'img_file' => 'image|mimes:jpg,jpeg,png|max:1024|nullable'
        ];
    }
}
