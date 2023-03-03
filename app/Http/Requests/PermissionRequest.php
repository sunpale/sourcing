<?php

namespace App\Http\Requests;

use App\Rules\AlpaSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required',new AlpaSpaceRule()],
            'guard_name' => ['required',new AlpaSpaceRule()]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
