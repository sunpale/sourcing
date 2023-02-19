<?php

namespace App\Http\Controllers\master_rm;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialRequest;
use App\Models\master_data\Brand;
use App\Models\master_data\Measure;
use App\Models\master_rm\Fabric;
use App\Models\master_rm\Komposisi;
use App\Models\master_rm\material;
use App\Models\master_warna\Color;
use App\Models\master_warna\Pantone;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    public function index()
    {
        return view('master_rm.main');
    }

    public function create()
    {
        $fabric = Fabric::all()->pluck('full_description','id');
        $warna = Color::all()->pluck('full_description','id');
        $brand = Brand::all()->pluck('full_brand','id');
        $pantone = Pantone::all()->pluck('full_pantone','id');
        $komposisi = Komposisi::select(['id','komposisi'])->pluck('komposisi','id');
        $measure = Measure::select(['id','kode'])->pluck('kode','id');
        $data = [
            'dataFabric' => $fabric,
            'dataWarna' => $warna,
            'dataBrand' => $brand,
            'dataPantone' => $pantone,
            'dataKomposisi' => $komposisi,
            'dataMeasure' => $measure
        ];
        return view('master_rm.create',$data);
    }

    public function store(MaterialRequest $request)
    {
        $data = $request->except(['_token','number']);
        $data['kode']=$request->number;
        material::create($data);
        return redirect()->route('raw-material.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function show(material $material)
    {
    }

    public function edit(material $material)
    {
    }

    public function update(Request $request, material $material)
    {
    }

    public function destroy(material $material)
    {
    }

    public function generateCode(Request $request){
        $prefix = $request->prefixCode;
        $lastKode = material::select('kode')->where('kode','LIKE','%'.$prefix.'%')->orderBy('created_at','desc')->withTrashed()->first();
        if(!isset($lastKode)){
            $result = array('kode'=>$prefix.'001');
        }
        return response()->json($result);
    }
}
