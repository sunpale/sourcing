<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SupplierForm extends Component
{
    public array $productGroup;
    public bool $editMode;
    public array $dataEdit;
    public function __construct(array|null $productGroup = null, $editMode =false, array $dataEdit = [])
    {
        $productGroup ??= [];
        $this->productGroup = $productGroup;
        $this->editMode = $editMode;
        $this->dataEdit = $dataEdit;
    }

    public function render(): View
    {
        return view('components.supplier-form');
    }
}
