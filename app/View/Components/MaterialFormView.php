<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MaterialFormView extends Component
{
    public array $material;
    public string $imageUrl;
    public string $form;
    public function __construct(array $material = [], string $form = 'RM',string $imageUrl='')
    {
        $this->material = $material;
        $this->form = $form;
        $this->imageUrl = $imageUrl;
    }

    public function render(): View
    {
        return view('components.material-form-view');
    }
}
