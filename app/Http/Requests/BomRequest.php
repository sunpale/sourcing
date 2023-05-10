<?php

namespace App\Http\Requests;

use App\Rules\FloatNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class BomRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'article_id' => 'required',
            'body_size.*' => 'required',
            'body_group.*' => 'required',
            'body_item.*' => 'required',
            'body_ratio.*'=>'required|integer|min:0',
            'body_cons.*' => ['required'/*,new FloatNumberRule()*/],
            'aks_ratio.*' => 'required|integer|min:0',
            'aks_size.*' => 'required',
            'aks_group.*' => 'required',
            'aks_item.*' => 'required',
            'aks_cons.*' => ['required'/*,new FloatNumberRule()*/],

            /*'kode' => ['required'],
            'article_id' => ['required'],
            'remarks' => ['nullable'],
            'revision' => ['required', 'integer'],
            'items' => ['required', 'date'],
            'created_by' => ['required', 'integer'],
            'updated_by' => ['required', 'integer'],
            'deleted_by' => ['nullable', 'integer'],
            'approved' => ['nullable', 'integer'],
            'approved_by' => ['nullable', 'integer'],*/
        ];
    }
}
