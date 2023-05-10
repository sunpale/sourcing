<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Layout extends Component
{
    public string $title;
    public string $breadcrumbs;
    public bool $datatable;
    public bool $datatableButton;
    public bool $datatableSelect;
    public bool $datatableRowGroup;
    public bool $jquery;
    public bool $sweetalert;
    public bool $toastify;
    public bool $freezeUi;
    public bool $select2;
    public bool $flatpickr;
    public bool $dropzone;
    public bool $cleavejs;

    public bool $glightbox;

    public bool $jsvalidation;

    public function __construct(string|null $breadcrumbs = null, string|null $title = null, bool|null $datatable = null, bool|null $select2 = null, bool|null $datatableButton = null, bool|null $datatableSelect = null, bool|null $datatableRowGroup = null, bool|null $sweetalert = null, bool|null $toastify = null, bool|null $freezeUi = null, bool|null $flatpickr = null, bool|null $dropzone = null, bool|null $jquery = null, bool|null $cleavejs = null, bool|null $glightbox = null, bool|null $jsvalidation = null)
    {
        $jquery ??= false;
        $freezeUi ??= false;
        $toastify ??= false;
        $sweetalert ??= false;
        $datatableRowGroup ??= false;
        $datatableSelect ??= false;
        $datatableButton ??= false;
        $select2 ??= false;
        $datatable ??= false;
        $title ??= 'Home';
        $breadcrumbs ??= 'main';
        $flatpickr ??=false;
        $dropzone ??=false;
        $cleavejs ??=false;
        $glightbox ??=false;
        $jsvalidation ??=false;
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
        $this->datatable = $datatable;
        $this->datatableButton = !$datatable ? false : $datatableButton;
        $this->datatableSelect = !$datatable ? false : $datatableSelect;
        $this->datatableRowGroup = !$datatable ? false : $datatableRowGroup;
        $this->select2 = $select2;
        $this->sweetalert = $sweetalert;
        $this->toastify = $toastify;
        $this->freezeUi = $freezeUi;
        $this->jquery = $datatable || $select2||$jquery;
        $this->flatpickr = $flatpickr;
        $this->dropzone = $dropzone;
        $this->cleavejs = $cleavejs;
        $this->glightbox = $glightbox;
        $this->jsvalidation = $jsvalidation;
    }

    public function render(): View
    {
        return view('template.layout');
    }
}
