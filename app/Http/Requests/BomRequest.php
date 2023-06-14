<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumericSpaceRule;
use App\Rules\FormatDecimalRule;
use Illuminate\Foundation\Http\FormRequest;

class BomRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'article_id'    => 'required|numeric',
            'body_size.*'   => 'required|numeric',
            'body_group.*'  => 'required|numeric',
            'body_item.*'   => 'required|numeric',
            'body_ratio.*'  => 'required|integer|min:0',
            'body_cons.*'   => ['required','regex:/^\d+(.\d{3})*(\,\d{1,4})?$/'],
            'aks_ratio.*'   => 'required|integer|min:0',
            'aks_size.*'    => 'required|numeric',
            'aks_group.*'   => 'required|numeric',
            'aks_item.*'    => 'required|numeric',
            'aks_cons.*'    => ['required','regex:/^\d+(.\d{3})*(\,\d{1,4})?$/'],
            'service.*'     => 'required|regex:/^[a-zA-Z\s\/\-]+$/',
            'service-id.*'  => 'required|numeric',
            'remarks.*'     => ['regex:/^[a-zA-Z0-9\s]+$/','max:100','nullable'],
            'service_cons.*'=> ['required','numeric','min:1'],
            'price.*'       => ['required','regex:/^\d+(.\d{3})*(\,\d{1,4})?$/']
        ];
    }

    public function messages(): array
    {
        return [
            'remarks.*.regex' => 'The :attribute field may only contain alphanumeric characters and spaces.',
            'price.*.regex'   => 'The :attribute field using an invalid format',
            'service.*.regex' => 'The :attribute field only accepts alphabetic characters, spaces and dash (-)',
            'aks_cons.*.regex'=> 'The :attribute field using an invalid format',
            'body_cons.*.regex' => 'The :attribute field using an invalid format',
        ];
    }
}
