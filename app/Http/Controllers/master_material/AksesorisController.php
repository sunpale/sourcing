<?php

namespace App\Http\Controllers\master_material;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_material\AksesorisRequest;
use App\Models\master_data\Brand;
use App\Models\master_data\Measure;
use App\Models\master_material\Material;
use App\Models\master_material\ProductGroup;
use App\Models\master_warna\Color;
use App\Models\master_warna\ColorAks;
use App\Services\ImageManipulation\ImageManipulationServiceImplement;
use App\Traits\StoreTrait;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Yajra\DataTables\Facades\DataTables;

class AksesorisController extends Controller
{
    use StoreTrait;
    private function getMaterialComponent(){
        $group = ProductGroup::all(['kode','type','group','id'])->where('type','Aksesoris')->pluck('full_group','id');
        $warna = Color::all()->pluck('full_description','id');
        $brand = Brand::all()->pluck('full_brand','id');
        $measure = Measure::select(['id','kode'])->pluck('kode','id');
        $warnaAks = ColorAks::all()->pluck('full_color','id');
        return compact('group','warna','brand','warnaAks','measure');
    }

    public function index()
    {
        return view('master_material.aksesoris.main');
    }

    public function create()
    {
        return view('master_material.aksesoris.create',$this->getMaterialComponent());
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function store(AksesorisRequest $request)
    {
        return $this->storeImplementation($request,'accessories','master-material.aksesoris.index');
    }

    public function data(){
        if(request()->ajax()){
            $query = Material::select(['id', 'kode','kode_infor','color_id','brand_id','product_group_id','supplier_id','color_aks_id','item_name','item_desc','measure_id'])
                ->with(['ProductGroup:id,group','color:id,description','brand:id,brand','supplier:id,name','ColorAks:id,color_desc','measure:id,kode,measure_name'])->where('fabric_id',null);
            return DataTables::eloquent($query)->order(function ($query){$query->orderBy('created_at','asc');})
                ->addIndexColumn()->addColumn('responsive',function (){return '';})
                ->addColumn('action',function ($row){
                    return '<div class="dropdown d-inline-block"><button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-equalizer-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" class="dropdown-item" onclick=edit("'.$row->id.'")><i class="ri-edit-fill"></i> Edit Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick=hapus("'.$row->id.'")><i class="ri-close-circle-fill"></i> Hapus Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="View Detail" class="dropdown-item" onclick=view("'.$row->id.'")><i class="ri-file-search-line"></i> View Detail</a></li></ul></div>';
                })->make(true);
        }
        return redirect()->route('master-aks.aksesoris.index');
    }

    public function show(Material $aksesori){
        $aksesoris = $aksesori->with(['user:id,username','ProductGroup:id,group','color:id,description','brand:id,brand','supplier:id,name','ColorAks:id,color_desc','measure:id,kode,measure_name'])->where('kode',$aksesori->kode)->get();
        $image = $aksesoris[0]->getFirstMediaUrl('accessories');
        return view('master_material.aksesoris.detail',compact('aksesoris','image'));
    }

    public function edit(Material $aksesori)
    {
        $materialComponent = $this->getMaterialComponent();
        $aks = $aksesori->with('supplier:id,kode,name')->where('kode',$aksesori->kode)->get();
        return view('master_material.aksesoris.edit',compact('aks')+$materialComponent);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(AksesorisRequest $request, Material $aksesori)
    {
        return $this->updateImplementation($request,'accessories','master-material.aksesoris.index',$aksesori);
    }

    public function destroy(Material $aksesori)
    {
        $aksesori->delete();
        $image = $aksesori->getMedia('accessories');
        if($image->count() >0){
            $aksesori->media()->update(['collection_name' => 'media-archived','disk' => 'media-archived','conversions_disk' => 'media-archived']);
            ImageManipulationServiceImplement::move_image($image,true);
        }
        return redirect()->route('master-material.aksesoris.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
