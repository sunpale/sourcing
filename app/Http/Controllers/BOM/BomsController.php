<?php

namespace App\Http\Controllers\BOM;

use App\Http\Controllers\Controller;
use App\Http\Requests\BomRequest;
use App\Models\BOM\Bom;
use App\Models\BOM\Bom_detail;
use App\Models\BOM\Bom_detail_service;
use App\Models\master_aks\ProductGroup;
use App\Models\master_data\Service;
use App\Models\master_data\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BomsController extends Controller
{
    public function index()
    {
        return view('bom.main');
    }

    public function create(){
        $size = Size::pluck('size','id');
        $productGroup = ProductGroup::select(['id','group'])->where('kode','!=','NG')->get();
        $service = Service::select(['name','id'])->get();
        return view('bom.create',compact('size','productGroup','service'));
    }

    public function store(Request $request)
    {
        $kode = 'BOM'.$request->article_id;
        $id = app('Kra8\Snowflake\Snowflake');
        $data = [
            'kode'          => $kode,
            'article_id'    => $request->article_id,
            'revision'      => 0,
            'status'        => 0
        ];
        DB::beginTransaction();
        $bom = Bom::create($data);
        if (!$bom){
            DB::rollBack();
            return redirect()->route('bom.index')->with('failed',config('constants.FAILED_SAVE'));
        }
        $detailBody=array();
        $detailAks = [];
        $detailService = [];
        if (isset($request->body_size)){
            for ($i=0;$i<count($request->body_size);$i++){
                $detailBody[$i] = array(
                    'id' => $id->short(),
                    'bom_id' => $bom->id,
                    'material_id' => $request->body_item[$i+1],
                    'product_group_id' => $request->body_group[$i+1],
                    'size_id' => $request->body_size[$i+1],
                    'ratio' =>$request->body_ratio[$i+1],
                    'cons' => str_replace(',','.',$request->body_cons[$i+1])
                );
            }
        }

        if (isset($request->aks_size)){
            for ($i=0;$i<count($request->aks_size);$i++){
                $detailAks[$i] = array(
                    'id' => $id->short(),
                    'bom_id' => $bom->id,
                    'material_id' => $request->aks_item[$i+1],
                    'product_group_id' => $request->aks_group[$i+1],
                    'size_id' => $request->aks_size[$i+1],
                    'ratio' =>$request->aks_ratio[$i+1],
                    'cons' => str_replace(',','.',$request->aks_cons[$i+1])
                );
            }
        }

        for ($i=0;$i<count($request->service);$i++){
            if ($request->price[$i+1] > 0){
                $detailService[] = array(
                    'id' => $id->short(),
                    'bom_id' => $bom->id,
                    'service_id' => $request->service_id[$i+1],
                    'remarks'   => $request->remarks[$i+1],
                    'cons'     => $request->service_cons[$i+1],
                    'price'     => str_replace(',','.',$request->price[$i+1])
                );
            }
        }

        $detail = array_merge($detailBody,$detailAks);
        if (!Bom_detail::insert($detail)){
            DB::rollBack();
            return redirect()->route('bom.index')->with('failed',config('constants.FAILED_SAVE'));
        }

        if (Bom_detail_service::insert($detailService)){
            DB::commit();
            return redirect()->route('bom.index')->with('success',config('constants.SUCCESS_SAVE'));
        }
        DB::rollBack();
        return redirect()->route('bom.index')->with('failed',config('constants.FAILED_SAVE'));
    }

    public function data(Request $request){
        if ($request->ajax()){
            $query = Bom::select(['id','kode','article_id','revision','status'])->with('article:id,kode');
            return DataTables::eloquent($query)->addIndexColumn()->addColumn('responsive',function (){return '';})
                ->addColumn('item',function ($row){
                    return '<a class="btn btn-info btn-xs" id="btnlist" href="#" data-bs-toggle="tooltip" data-placement="auto" title="Klik Untuk Melihat Bom Item"><i class="ri-list-ordered"></i> List Item</a>';
                })
                ->addColumn('action',function ($row){
                    return '<div class="dropdown d-inline-block"><button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-equalizer-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a id="btnedit" href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" class="dropdown-item" onclick=edit("'.$row->id.'")><i class="ri-edit-fill"></i> Edit Data</a></li><li><a id="btnhapus" href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick=hapus("'.$row->id.'")><i class="ri-close-circle-fill"></i> Hapus Data</a></li></ul></div>';
                })->rawColumns(['item','action'])->make();
        }
        return redirect()->route('bom.index');
    }
    public function findBom(Bom $bom){
        $material = Bom_detail::select(['material_id','product_group_id','size_id','ratio','cons',DB::raw('price*cons as sub_total')])->with(['material:id,kode,item_name,unit_price','size:id,size','ProductGroup:id,group'])->where('bom_id',$bom->id)->get();
        $jasa = Bom_detail_service::select(['id','bom_id','service_id','remarks','cons','price','cons',DB::raw('price*cons as sub_total')])->with('service:id,name')->where('bom_id',$bom->id)->get();
        $sumMaterial = number_format($material->sum('sub_total'),2,',','.');
        $sumJasa = number_format($jasa->sum('sub_total'),2, ',', '.');
        return response()->json(compact('material','jasa','sumJasa','sumMaterial'));
    }
    public function show(Bom $bom)
    {
        return $bom;
    }

    public function update(BomRequest $request, Bom $bom)
    {
        $bom->update($request->validated());

        return $bom;
    }

    public function destroy(Bom $bom)
    {
        $bom->delete();

        return response()->json();
    }
}
