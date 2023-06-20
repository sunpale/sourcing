<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MaterialForm extends Component
{
    public string $form;
    public array $fabric;
    public array $warna;
    public array $brand;
    public array $pantone;
    public array $komposisi;
    public array $measure;
    public bool $editMode;
    public array $dataEdit;
    public array $group;
    public array $warnaAks;
    public function __construct(string|null $form = null, array|null $fabric = null, array|null $warna = null, array|null $brand = null, array|null $pantone = null, array|null $komposisi = null, array|null $measure = null, bool|null $editMode = null, array $dataEdit = [], array|null $group = null, array|null $warnaAks = null)
    {
        $editMode ??= false;
        $measure ??= [];
        $komposisi ??= [];
        $pantone ??= [];
        $brand ??= [];
        $warna ??= [];
        $fabric ??= [];
        $form ??= "RM";
        $group ??= [];
        $warnaAks ??=[];
        $this->form = $form;
        $this->fabric = $fabric;
        $this->warna = $warna;
        $this->brand = $brand;
        $this->pantone = $pantone;
        $this->komposisi = $komposisi;
        $this->measure = $measure;
        $this->editMode = $editMode;
        $this->dataEdit = $dataEdit;
        $this->group = $group;
        $this->warnaAks = $warnaAks;
    }

    public function render(): View
    {
        return view('components.material-form');
    }
}
