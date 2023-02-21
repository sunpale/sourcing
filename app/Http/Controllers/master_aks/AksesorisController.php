<?php

namespace App\Http\Controllers\master_aks;

use App\Http\Controllers\Controller;
use App\Models\master_aks\ProductGroup;
use App\Models\master_data\Brand;
use App\Models\master_data\Measure;
use App\Models\master_warna\Color;
use App\Models\master_warna\ColorAks;

class AksesorisController extends Controller
{
    public function index()
    {
        return view('master_aks.main');
    }

    public function create(){
        $data = [
            'dataGroup' => ProductGroup::where('id','>',1)->pluck('group','id'),
            'dataWarna' => Color::all()->pluck('full_description','id'),
            'dataBrand' => Brand::all()->pluck('full_brand','id'),
            'dataMeasure' => Measure::select(['id','kode'])->pluck('kode','id'),
            'dataWarnaAks' => ColorAks::all()->pluck('full_color','id')
        ];
        return view('master_aks.create',$data);
    }
}
