<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\master_aks\ProductGroup;
use App\Models\master_data\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuppliersController extends Controller
{
    public function index()
    {
        return view('master_data.supplier.main');
    }

    public function create()
    {
        $data = [
            'dataGroup' => ProductGroup::select(['id','group'])->get()
        ];
        return view('master_data.supplier.create',$data);
    }

    private function generateCode(){
        $stringList = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        while (strlen($code) < 3){
            $position = rand(0,strlen($stringList)-1);
            $character = $stringList[$position];
            $code .= $character;
        }

        return $this->validateCodeGenerated($code);
    }

    private function validateCodeGenerated(string $kode):string{
        if (Supplier::where('kode',$kode)->exists()){
            $this->generateCode();
        }
        return $kode;
    }

    public function store(SupplierRequest $request)
    {
        $data = $request->except('_token');
        $data['kode'] = $this->generateCode();
        if (!isset($request->product_group_id))
            $data['product_group_id'] = '0';
        Supplier::create($data);
        return redirect()->route('supplier.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function show(Request $request)
    {
        if($request->ajax()){
            $query = Supplier::select(['id','kode','type','product_group_id','name','address'])->with('ProductGroup:id,group');
            return DataTables::eloquent($query)
                ->addIndexColumn()->addColumn('responsive',function (){return '';})
                ->addColumn('action',function ($row){
                    return '<div class="dropdown d-inline-block"><button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-equalizer-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" class="dropdown-item" onclick=edit("'.$row->id.'")><i class="ri-edit-fill"></i> Edit Data</a></li><li><a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick=hapus("'.$row->id.'")><i class="ri-close-circle-fill"></i> Hapus Data</a></li></ul></div>';
                })->make(true);
        }
    }

    public function edit(Supplier $supplier)
    {
        $data = [
            'dataGroup' => ProductGroup::select(['id','group'])->get(),
            'supplier' => $supplier
        ];
        return view('master_data.supplier.edit',$data);
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $data = $request->except(['_token','_method']);
        if (!isset($request->product_group_id))
            $data['product_group_id'] = '0';

        Supplier::where('id',$supplier->id)->update($data);
        return redirect()->route('supplier.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Supplier $supplier)
    {
        Supplier::destroy($supplier->id);
        return redirect()->route('supplier.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
