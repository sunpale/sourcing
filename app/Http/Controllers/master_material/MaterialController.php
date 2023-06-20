<?php

namespace App\Http\Controllers\master_material;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_material\MaterialRequest;
use App\Models\master_data\Brand;
use App\Models\master_data\Measure;
use App\Models\master_material\Fabric;
use App\Models\master_material\Komposisi;
use App\Models\master_material\Material;
use App\Models\master_material\ProductGroup;
use App\Models\master_warna\Color;
use App\Models\master_warna\Pantone;
use App\Services\CodeGenerator\CodeGeneratorServiceImplement;
use App\Services\ImageManipulation\ImageManipulationServiceImplement;
use Exception;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Yajra\DataTables\Facades\DataTables;

class MaterialController extends Controller
{
    private function getMaterialComponent(){
        $fabric = Fabric::all()->pluck('full_description','id');
        $warna = Color::all()->pluck('full_description','id');
        $brand = Brand::all()->pluck('full_brand','id');
        $pantone = Pantone::all()->pluck('full_pantone','id');
        $komposisi = Komposisi::select(['id','komposisi'])->pluck('komposisi','id');
        $measure = Measure::select(['id','kode'])->pluck('kode','id');
        $group = ProductGroup::all(['id','kode','type','group'])->where('type','Raw Material')->pluck('full_group','id');
        return compact('fabric','warna','brand','pantone','komposisi','measure','group');
    }

    public function index()
    {
        return view('master_material.main');
    }

    public function create(){
        $materialComponent = $this->getMaterialComponent();
        return view('master_material.create',$materialComponent);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(MaterialRequest $request)
    {
        $data = $request->except(['_token','number','img_file']);
        $kodeGenerated = $request->number;
        $prefix = substr($kodeGenerated,0,strlen($kodeGenerated)-4);
        $kode = $this->createCode($prefix);
        $data['kode'] = $kode;
        $data['unit_price'] = str_replace('.','',$request->unit_price);
        $material = Material::create($data);
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $image = $request->file('img_file');
            $filename = $kode.'.'.$image->extension();
            $material->addMediaFromRequest('img_file')->usingName($kode)->usingFileName($filename)->storingConversionsOnDisk('media-thumb')->withCustomProperties(['extension' => $image->extension()])->toMediaCollection('raw material');
        }
        return redirect()->route('master-material.raw-material.index')->with(config('constants.SUCCESS_SAVE'));
    }

    public function show(Material $raw_material)
    {
        $rm = $raw_material->with(['user:id,username','fabric:id,description','color:id,description','brand:id,brand','supplier:id,name','komposisi:id,komposisi','measure:id,kode,measure_name'])->where('kode',$raw_material->kode)->get();
        $image = $rm[0]->getFirstMediaUrl('raw material');
        return view('master_material.detail',compact('rm','image'));
    }

    /**
     * @throws Exception
     */
    public function data(){
        if(request()->ajax()){
            $query = Material::select(['id','kode','kode_infor','fabric_id','color_id','brand_id','supplier_id','komposisi_id','item_name','item_desc','measure_id'])
                ->with(['fabric:id,description','color:id,description','brand:id,brand','supplier:id,name','komposisi:id,komposisi','measure:id,kode,measure_name'])->where('fabric_id','<>',null);
            return DataTables::eloquent($query)->order(function ($query){$query->orderBy('created_at','asc');})
                ->addIndexColumn()->addColumn('responsive',function (){return '';})
                ->addColumn('action',function ($row){
                    return '<div class="dropdown d-inline-block"><button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-equalizer-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" class="dropdown-item" onclick=edit("'.$row->id.'")><i class="ri-edit-fill"></i> Edit Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick=hapus("'.$row->id.'")><i class="ri-close-circle-fill"></i> Hapus Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="View Detail" class="dropdown-item" onclick=view("'.$row->id.'")><i class="ri-file-search-line"></i> View Detail</a></li></ul></div>';
                })->make();
        }
        return redirect()->route('master-material.raw-material.index');
    }

    public function edit(Material $raw_material)
    {
        $materialComponent = $this->getMaterialComponent();
        $material = $raw_material->with('supplier:id,kode,name')->where('id',$raw_material->id)->get();
        return view('master_material.edit',compact('material')+$materialComponent);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(MaterialRequest $request, Material $raw_material)
    {
        $data = $request->except(['_token','_method','number','img_file']);
        $kodeGenerated = $request->number;
        $prefixOldKode = substr($raw_material->kode,0,strlen($raw_material->kode)-4);
        $prefix = substr($kodeGenerated,0,strlen($kodeGenerated)-4);
        $kode = strcmp($prefix,$prefixOldKode) == 0 ? $raw_material->kode : $this->createCode($prefix);
        $data['kode'] = $kode;
        $data['unit_price'] = str_replace('.','',$request->unit_price);

        $raw_material->update($data);

        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $image = $request->file('img_file');
            $filename = $kode.'.'.$image->extension();
            /*cek apakah kodenya berbeda, jika berbeda gambar sebelumnya akan dihapus dan diganti dengan gambar yang baru*/
            if(strcmp($request->old_kode,$kode)!=0){
                $media = $raw_material->getMedia('raw material');
                if ($media->count() > 0){
                    ImageManipulationServiceImplement::delete_image($media);
                }
            }
            $raw_material->media()->delete();
            $raw_material->addMediaFromRequest('img_file')->usingName($kode)->usingFileName($filename)->storingConversionsOnDisk('media-thumb')->withCustomProperties(['extension'=>$image->extension()])->toMediaCollection('raw material');
        }else{
            $image = $raw_material->getMedia('raw material');
            if ($image->count() > 0) {
                $updateNameFile = $raw_material->media()->update(['name' => $kode,'file_name'=>$kode.'.'.$image[0]->custom_properties['extension']]);
                if ($updateNameFile)
                    ImageManipulationServiceImplement::rename_image($image,$kode);
            }
        }
        return redirect()->route('master-material.raw-material.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Material $raw_material)
    {
        $raw_material->delete();
        $image = $raw_material->getMedia('raw material');
        if($image->count() >0){
            $raw_material->media()->update(['collection_name' => 'media-archived','disk' => 'media-archived','conversions_disk' => 'media-archived']);
            ImageManipulationServiceImplement::move_image($image,true);
        }
        return redirect()->route('master-material.raw-material.index')->with('success',config('constants.SUCCESS_DELETE'));
    }

    private function createCode(string $prefix){
        $lastKode = Material::select('kode')->where('kode','LIKE','%'.$prefix.'%')->orderBy('created_at','desc')->withTrashed()->get();
        return CodeGeneratorServiceImplement::generate($lastKode,$prefix,8,4);
    }

    public function generateCode(Request $request){
        $kode = $this->createCode($request->prefixCode);
        return response()->json(compact('kode'));
    }
}
