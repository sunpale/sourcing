<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $label;
    public string $id;
    public string $type;
    public string $name;
    public string $value;
    public string $placeholder;
    public bool $isRequired;
    public string $marginBottom;
    public string $formInput;

    public function __construct(string|null $formInput= null, string|null $label = null, string|null $id = null, string|null $type = null, string|null $name = null, string|null $value = null, bool|null $isRequired = null, string|null $placeholder = null, string|null $marginBottom = null)
    {
        $marginBottom ??= 'mb-2';
        $placeholder ??= '';
        $isRequired ??= false;
        $value ??= '';
        $name ??= '';
        $type ??= 'text';
        $id ??= '';
        $label ??= '';
        $formInput ??= 'input';
        $this->formInput = $formInput;
        $this->label = $label;
        $this->id   = $id;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->isRequired = $isRequired;
        $this->placeholder = $placeholder==='' ? $label:$placeholder;
        $this->marginBottom = $marginBottom;
    }

    public function render(): View
    {
        return view('components.forms.input');
    }
}
