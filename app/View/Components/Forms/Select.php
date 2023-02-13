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
    public string $dataValue;
    public string $dataColumn;

    public function __construct(string $id = null,string $name = '',string $value = '', string $marginBottom='mb-2',string $label = '',array $listValue = [],string $dataValue = '',string $dataColumn = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->marginBottom = $marginBottom;
        $this->label = $label;
        $this->listValue = $listValue;
        $this->dataValue = $dataValue;
        $this->dataColumn = $dataColumn;
    }
    public function render(): View
    {
        return view('components.forms.select');
    }
}
