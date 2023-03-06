<?php

namespace App\Http\Controllers\master_aks;

use App\Http\Controllers\Controller;
use App\Http\Requests\AksesorisRequest;
use App\Models\master_aks\ProductGroup;
use App\Models\master_data\Brand;
use App\Models\master_data\Measure;
use App\Models\master_rm\Material;
use App\Models\master_warna\Color;
use App\Models\master_warna\ColorAks;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AksesorisController extends Controller
{
    public function index()
    {
        return view('master_aks.main');
    }

    public function create(){
        $data = [
            'dataGroup' =>ProductGroup::all(['kode','group','id'])->where('id','>',1)->pluck('full_group','id'),
            'dataWarna' => Color::all()->pluck('full_description','id'),
            'dataBrand' => Brand::all()->pluck('full_brand','id'),
            'dataMeasure' => Measure::select(['id','kode'])->pluck('kode','id'),
            'dataWarnaAks' => ColorAks::all()->pluck('full_color','id')
        ];
        return view('master_aks.create',$data);
    }

    public function store(AksesorisRequest $request){
        $data = $request->except(['_token','number']);
        $kodeGenerated = $request->number;
        $prefix = substr($kodeGenerated,0,strlen($kodeGenerated)-4);
        $kode = $this->createCode($prefix);
        $data['kode'] = $kode;
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $path = 'private/aks/';
            $data['image_path'] = $path;
            $data['image_name'] = $kode;

            if ($this->save($data)){
                $imageSource = $request->file('img_file');
                $imageSource->storeAs($path,$kode.'.'.$imageSource->extension());
            }
        }else{
            $this->save($data);
        }
        return redirect()->route('master-aks.aksesoris.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function show(Material $aksesori){
        $data = ['aksesoris'=>$aksesori->with(['user:id,username','ProductGroup:id,group','color:id,description','brand:id,brand','supplier:id,name','ColorAks:id,color_desc','measure:id,kode,measure_name'])->where('kode',$aksesori->kode)->get()];
        return view('master_aks.detail',$data);
    }

    public function data(){
        if(request()->ajax()){
            $query = Material::select(['kode','kode_infor','color_id','brand_id','product_group_id','supplier_id','color_aks_id','item_name','item_desc','measure_id'])
                ->with(['ProductGroup:id,group','color:id,description','brand:id,brand','supplier:id,name','ColorAks:id,color_desc','measure:id,kode,measure_name'])->where('fabric_id',null);
            return DataTables::eloquent($query)->order(function ($query){$query->orderBy('created_at','asc');})
                ->addIndexColumn()->addColumn('responsive',function (){return '';})
                ->addColumn('action',function ($row){
                    return '<div class="dropdown d-inline-block"><button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-equalizer-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" class="dropdown-item" onclick=edit("'.$row->kode.'")><i class="ri-edit-fill"></i> Edit Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick=hapus("'.$row->kode.'")><i class="ri-close-circle-fill"></i> Hapus Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="View Detail" class="dropdown-item" onclick=view("'.$row->kode.'")><i class="ri-file-search-line"></i> View Detail</a></li></ul></div>';
                })->make(true);
        }
        return redirect()->route('master-aks.aksesoris.index');
    }

    public function edit(Material $aksesori)
    {
        $data = [
            'dataGroup' =>ProductGroup::all(['kode','group','id'])->where('id','>',1)->pluck('full_group','id'),
            'dataWarna' => Color::all()->pluck('full_description','id'),
            'dataBrand' => Brand::all()->pluck('full_brand','id'),
            'dataMeasure' => Measure::select(['id','kode'])->pluck('kode','id'),
            'dataWarnaAks' => ColorAks::all()->pluck('full_color','id'),
            'dataAks'    => $aksesori->with('supplier:id,kode,name')->where('kode',$aksesori->kode)->get()
        ];
        return view('master_aks.edit',$data);
    }

    public function update(AksesorisRequest $request, Material $aksesori)
    {
        $data = $request->except(['_token','_method','number','img_file']);
        $kodeGenerated = $request->number;
        $prefixOldKode = substr($aksesori->kode,0,strlen($aksesori->kode)-4);
        $prefix = substr($kodeGenerated,0,strlen($kodeGenerated)-4);
        $kode = strcmp($prefix,$prefixOldKode) == 0 ? $aksesori->kode : $this->createCode($prefix);
        $data['kode'] = $kode;
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $path = 'private/aks/';
            $data['image_path'] = $path;
            $data['image_name'] = $kode;

            if ($this->change($data,$aksesori->kode)){
                $imageSource = $request->file('img_file');
                $imageSource->storeAs($path,$kode.'.'.$imageSource->extension());
            }
        }else{
            $this->change($data,$aksesori->kode);
        }
        return redirect()->route('master-aks.aksesoris.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Material $aksesori)
    {
        Material::destroy($aksesori->kode);
        return redirect()->route('master-aks.aksesoris.index')->with('success',config('constants.SUCCESS_DELETE'));
    }

    public function viewImage($filename){
        $file = storage_path('app/private/aks/'.$filename);
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
