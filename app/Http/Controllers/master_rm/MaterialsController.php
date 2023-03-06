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
        $prefix = substr($kodeGenerated,0,strlen($kodeGenerated)-4);
        $kode = $this->createCode($prefix);
        $data['kode'] = $kode;
        $imageSource = $request->file('img_file');
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $path = 'private/rm/';
            $data['image_path'] = $path;
            $data['image_name'] = $kode.'.'.$imageSource->extension();

            if($this->save($data)){
                $imageSource->storeAs($path,$kode.'.'.$imageSource->extension());
            }
        }else{
            $this->save($data);
        }
        return redirect()->route('master-rm.raw-material.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function show(Material $raw_material)
    {
        $data = ['rm'=>$raw_material->with(['user:id,username','fabric:id,description','color:id,description','brand:id,brand','supplier:id,name','komposisi:id,komposisi','measure:id,kode,measure_name'])->where('kode',$raw_material->kode)->get()];
        return view('master_rm.detail',$data);
    }

    public function data(){
        if(request()->ajax()){
            $query = Material::select(['kode','kode_infor','fabric_id','color_id','brand_id','supplier_id','komposisi_id','item_name','item_desc','measure_id'])
                ->with(['fabric:id,description','color:id,description','brand:id,brand','supplier:id,name','komposisi:id,komposisi','measure:id,kode,measure_name'])->where('fabric_id','<>',null);
            return DataTables::eloquent($query)->order(function ($query){$query->orderBy('created_at','asc');})
                ->addIndexColumn()->addColumn('responsive',function (){return '';})
                ->addColumn('action',function ($row){
                    return '<div class="dropdown d-inline-block"><button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-equalizer-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" class="dropdown-item" onclick=edit("'.$row->kode.'")><i class="ri-edit-fill"></i> Edit Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick=hapus("'.$row->kode.'")><i class="ri-close-circle-fill"></i> Hapus Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="View Detail" class="dropdown-item" onclick=view("'.$row->kode.'")><i class="ri-file-search-line"></i> View Detail</a></li></ul></div>';
                })->make(true);
        }
        return redirect()->route('master-rm.raw-material.index');
    }


    public function edit(Material $raw_material)
    {
        $data = [
            'dataFabric' => Fabric::all()->pluck('full_description','id'),
            'dataWarna' => Color::all()->pluck('full_description','id'),
            'dataBrand' => Brand::all()->pluck('full_brand','id'),
            'dataPantone' => Pantone::all()->pluck('full_pantone','id'),
            'dataKomposisi' => Komposisi::select(['id','komposisi'])->pluck('komposisi','id'),
            'dataMeasure' => Measure::select(['id','kode'])->pluck('kode','id'),
            'dataRm'    => $raw_material->with('supplier:id,kode,name')->where('kode',$raw_material->kode)->get()
        ];
        return view('master_rm.edit',$data);
    }

    public function update(MaterialRequest $request, Material $raw_material)
    {
        $data = $request->except(['_token','_method','number','img_file']);
        $kodeGenerated = $request->number;
        $prefixOldKode = substr($raw_material->kode,0,strlen($raw_material->kode)-4);
        $prefix = substr($kodeGenerated,0,strlen($kodeGenerated)-4);
        $kode = strcmp($prefix,$prefixOldKode) == 0 ? $raw_material->kode : $this->createCode($prefix);
        $data['kode'] = $kode;
        $imageSource = $request->file('img_file');
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $path = 'private/rm';
            $data['image_path'] = $path;
            $data['image_name'] = $kode.'.'.$imageSource->extension();

            if ($this->change($data,$raw_material->kode)){
                $imageSource->storeAs($path,$kode.'.'.$imageSource->extension());
            }
        }else{
            $this->change($data,$raw_material->kode);
        }
        return redirect()->route('master-rm.raw-material.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Material $raw_material)
    {
        Material::destroy($raw_material->kode);
        return redirect()->route('master-rm.raw-material.index')->with('success',config('constants.SUCCESS_DELETE'));
    }

    public function viewImage($filename){
        $file = storage_path('app/private/rm/'.$filename);
        return response()->file($file);
    }

    private function save(array $data){
        return Material::create($data);
    }

    private function change(array $data,string $kode){
        return Material::where('kode',$kode)->update($data);
    }

    private function createCode(string $prefix){
        $lastKode = Material::select('kode')->where('kode','LIKE','%'.$prefix.'%')->orderBy('created_at','desc')->withTrashed()->first();
        if(!isset($lastKode)){
            return $prefix.'0001';
        }
        $number = substr($lastKode->kode,8,4);
        $id = intval($number);
        $id += 1;
        $idLength = strlen($id);
        $prefixCode='';
        for ($i=$idLength;$i<4;$i++){
            $prefixCode .= '0';
        }
        return $prefix.$prefixCode.$id;
    }

    public function generateCode(Request $request){
        $kode = $this->createCode($request->prefixCode);
        $result = compact('kode');
        return response()->json($result);
    }
}
