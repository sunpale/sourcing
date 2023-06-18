<?php

namespace App\Http\Requests\auth;

use App\Rules\AlphaSpaceRule;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required',new AlphaSpaceRule()],
            'guard_name' => ['required',new AlphaSpaceRule()]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
