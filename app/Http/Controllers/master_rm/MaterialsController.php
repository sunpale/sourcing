<?php

namespace App\Http\Controllers\master_rm;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialRequest;
use App\Models\master_data\Brand;
use App\Models\master_data\Measure;
use App\Models\master_rm\Fabric;
use App\Models\master_rm\Komposisi;
use App\Models\master_rm\Material;
use App\Models\master_warna\Color;
use App\Models\master_warna\Pantone;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
        $kodeGenerated = $request->number;
        $prefix = substr($kodeGenerated,0,strlen($kodeGenerated)-3);
        $data['kode']=$this->createCode($prefix);
        Material::create($data);
        return redirect()->route('raw-material.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function show()
    {
        if(request()->ajax()){
            $query = Material::select(['kode','kode_infor','fabric_id','color_id','brand_id','supplier_id','komposisi_id','item_name','item_desc','measure_id'])
                ->with(['fabric:id,description','color:id,description','brand:id,brand','supplier:id,name','komposisi:id,komposisi','measure:id,kode,measure_name']);
            return DataTables::eloquent($query)
                ->addIndexColumn()->addColumn('responsive',function (){return '';})
                ->addColumn('action',function ($row){
                    return '<div class="dropdown d-inline-block"><button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-equalizer-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" class="dropdown-item" onclick=edit("'.$row->kode.'")><i class="ri-edit-fill"></i> Edit Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick=hapus("'.$row->kode.'")><i class="ri-close-circle-fill"></i> Hapus Data</a></li></ul></div>';
                })->make(true);
        }
    }

    public function edit(Material $raw_material)
    {
    }

    public function update(Request $request, Material $raw_material)
    {
    }

    public function destroy(Material $raw_material)
    {
        Material::destroy($raw_material->kode);
        return redirect()->route('raw-material.index')->with('success',config('constants.SUCCESS_DELETE'));
    }

    private function createCode(string $prefix){
        $lastKode = Material::select('kode')->where('kode','LIKE','%'.$prefix.'%')->orderBy('created_at','desc')->withTrashed()->first();
        if(!isset($lastKode)){
            return $prefix.'001';
        }
        $number = substr($lastKode->kode,11,4);
        $id = intval($number);
        $id += 1;
        $idLength = strlen($id);
        $prefixCode='';
        for ($i=$idLength;$i<3;$i++){
            $prefixCode .= '0';
        }
        return $prefix.$prefixCode.$id;
    }

    public function generateCode(Request $request){
        $kode = $this->createCode($request->prefixCode);
        $result = ['kode'=>$kode];
        return response()->json($result);
    }
}
