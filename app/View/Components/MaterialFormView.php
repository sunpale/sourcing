<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MaterialFormView extends Component
{
    public array $material;
    public string $form;
    public function __construct(array $material = [], string $form = 'RM')
    {
        $this->material = $material;
        $this->form = $form;
    }

    public function render(): View
    {
        return view('components.material-form-view');
    }
}
