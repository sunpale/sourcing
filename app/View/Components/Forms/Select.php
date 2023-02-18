<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $id;
    public string $label;
    public string $name;
    public string $value;
    public string $marginBottom;
    public array $listValue;

    public function __construct(string|null $id = null, string|null $name = null, string|null $value = null, string|null $marginBottom= null, string|null $label = null, array|null $listValue = null)
    {
        $listValue ??= [];
        $label ??= '';
        $marginBottom ??= 'mb-2';
        $value ??= '';
        $name ??= '';
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->marginBottom = $marginBottom;
        $this->label = $label;
        $this->listValue = $listValue;
    }
    public function render(): View
    {
        return view('components.forms.select');
    }
}
