<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumericPunctRule;
use App\Rules\AlphaNumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class AksesorisRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_group_id'  => 'required|numeric',
            'color_aks_id'      => 'required|numeric',
            'brand_id'          => 'required|numeric',
            'supplier_id'       => 'required|numeric',
            'item_name'         => ['required',new AlphaNumericPunctRule(),'max:100'],
            'item_desc'         => ['required',new AlphaNumericPunctRule(),'max:255'],
            'lead_time'         => 'required|numeric',
            'moq'               => 'required|numeric',
            'ppn'               => 'required|numeric',
            'measure_id'        => 'required|numeric',
            'color_id'          => 'required|numeric',
            'img_file'          => 'image|mimes:jpg,jpeg|max:3072|nullable'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
