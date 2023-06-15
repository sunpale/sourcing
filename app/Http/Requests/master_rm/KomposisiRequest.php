<?php

namespace App\Http\Requests\master_rm;

use App\Rules\AlphaNumericPunctRule;
use App\Rules\AlphaNumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class KomposisiRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'komposisi'=> ['required',new AlphaNumericPunctRule(),'max:50'],
            'keterangan'=> [new AlphaNumericSpaceRule(),'max:100','nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
