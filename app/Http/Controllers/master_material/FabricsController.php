<?php

namespace App\Http\Controllers\master_material;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_material\FabricRequest;
use App\Models\master_material\Fabric;
use App\Services\CodeGenerator\CodeGeneratorServiceImplement;
use Illuminate\Http\Request;

class FabricsController extends Controller
{
    public function index()
    {
        $fabric = Fabric::select(['id','kode','description'])->get();
        $data = [
            'dataFabric' => $fabric
        ];
        return view('master_material.fabric.main',$data);
    }

    public function generateCode(Request $request){
        $prefix = $request->prefix;
        $lastCode = Fabric::select('kode')->where('kode','LIKE','%'.$prefix.'%')->latest()->get();
        $generatedCode = ['code' => CodeGeneratorServiceImplement::generate($lastCode,$prefix,1,2,'kode')];
        return response()->json($generatedCode);
    }

    public function store(FabricRequest $request)
    {
        Fabric::create($request->only(['kode','description']));
        return redirect()->route('master-material.fabric.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Fabric $fabric)
    {
        return response()->json($fabric);
    }

    public function update(Request $request, Fabric $fabric)
    {
        $fabric->update($request->only(['kode','description']));
        return redirect()->route('master-material.fabric.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Fabric $fabric)
    {
        $fabric->delete();
        return redirect()->route('master-material.fabric.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
