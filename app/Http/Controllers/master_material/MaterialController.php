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
use App\Traits\StoreTrait;
use Exception;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Yajra\DataTables\Facades\DataTables;

class MaterialController extends Controller
{
    use StoreTrait;
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
        return $this->storeImplementation($request,'raw material','master-material.raw-material.index');
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
        return $this->updateImplementation($request,'raw material','master-material.raw-material.index',$raw_material);
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

    public function generateCode(Request $request){
        $kode = $this->createCode($request->prefixCode);
        return response()->json(compact('kode'));
    }

    public function getMaterials(Request $request){
        /*get data pencarian dan jumlah halaman dari komponen select2*/
        $search = $request->search;
        $halaman = $request->page;
        $group = $request->group;
        $searchData = empty($search) ? "" : $search;
        /*$type = $request->type;*/
        /*end*/
        /*Set jumlah data per halaman*/
        $pageLoad = 25;
        /*End*/
        /*Cek jumlah halaman, kemudian dikurang satu (offset data di mulai dari 0)*/
        if($halaman==1){
            $page=0;
        }else{
            /*Jika halaman lebih dari 1, maka setelah dikurang satu dikalikan jumlah data per halaman untuk mendapatkan data offset halaman berikutnya*/
            $page=($halaman-1)*$pageLoad;
            /*end*/
        }
        /*end*/
        /*Memanggil data dan jumlah data dari database*/
        $dataItem=Material::select(['id','kode','item_name'])->where('product_group_id',$group)->where('kode','LIKE','%'.$searchData.'%')->orWhere('product_group_id',$group)->where('item_name','LIKE','%'.$searchData.'%')->limit($pageLoad)->offset($page)->get();
        $dataCount=Material::select(['id','kode','item_name'])->where('product_group_id',$group)->where('kode','LIKE','%'.$searchData.'%')->orWhere('product_group_id',$group)->where('item_name','LIKE','%'.$searchData.'%')->count();
        /*End*/

        /*Mengubah hasil data dari database sesuai dengan format dari select2*/
        $result=array();
        foreach ($dataItem as $item){
            $result[] = array("id" => $item->id,"text"=>$item->kode.' - '.$item->item_name);
        }
        $resultQuery['items']=$result;
        $resultQuery['total_count']=$dataCount;
        /*End*/
        return response()->json($resultQuery);
    }

    public function getImageAndPrice($kode){
        $price = Material::select(['id','unit_price'])->where('id',$kode)->get();
        $image = $price[0]->getFirstMediaUrl('raw material');
        $result = array(
            'price' => $price[0]->unit_price,
            'image' => $image
        );
        return response()->json($result);
    }
}
