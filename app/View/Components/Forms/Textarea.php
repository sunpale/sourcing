<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public string $id;
    public string $label;
    public string $name;
    public string $value;
    public string $marginBottom;
    public int $row;

    public function __construct(string $id = null,string $name = '',string $value = '', string $marginBottom='mb-2',string $label = '',int $row=3)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->marginBottom = $marginBottom;
        $this->label = $label;
        $this->row = $row;
    }

    public function render(): View
    {
        return view('components.forms.textarea');
    }
}
