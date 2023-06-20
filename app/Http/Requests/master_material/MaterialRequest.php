<?php

namespace App\Http\Requests\master_material;

use App\Rules\AlphaNumericPunctRule;
use App\Rules\AlphaNumericSpaceRule;
use App\Rules\FormatDecimalRule;
use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fabric_id'     => 'required|numeric',
            'color_id'      => 'required|numeric',
            'brand_id'      => 'required|numeric',
            'product_group_id' => 'required|numeric',
            'supplier_id'   => 'required|numeric',
            'pantone_id'    => 'required|numeric',
            'komposisi_id'  => 'required|numeric',
            'item_name'     => ['required',new AlphaNumericPunctRule(),'max:100'],
            'item_desc'     => ['required',new AlphaNumericPunctRule(),'max:255'],
            'gramasi'       => ['required',new AlphaNumericPunctRule(),'max:25'],
            'lebar'         => ['required',new AlphaNumericPunctRule(),'max:15'],
            'susut'         => 'required|numeric',
            'finish'        => ['required',new AlphaNumericSpaceRule(),'max:25'],
            'lead_time'     => 'required|numeric',
            'moq'           => 'required|numeric',
            'moq_color'     => 'required|numeric',
            'ppn'           => 'required|numeric',
            'measure_id'    => 'required|numeric',
            'unit_price'    => ['required',new FormatDecimalRule()],
            'img_file'      => 'image|mimes:jpg,jpeg|max:1024|nullable'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
