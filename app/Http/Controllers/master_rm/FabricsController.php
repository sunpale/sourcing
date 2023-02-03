<?php

namespace App\Http\Controllers\master_rm;

use App\Http\Controllers\Controller;
use App\Http\Requests\FabricRequest;
use App\Models\master_rm\Fabric;
use Illuminate\Http\Request;

class FabricsController extends Controller
{
    public function index()
    {
        $fabric = Fabric::select(['id','kode','description'])->get();
        $data = [
            'dataFabric' => $fabric
        ];
        return view('master_rm.fabric.main',$data);
    }

    public function generateCode(Request $request){
        $prefix = $request->prefix;
        $result = Fabric::select('kode')->where('kode','LIKE','%'.$prefix.'%')->latest()->get();
        if ($result->count()==0){
            $generatedCode = $prefix.'01';
        }else{
            $lastNumber = (int)substr($result[0]->kode, 1, 2);
            $newNumber = $lastNumber + 1;
            $length =strlen($newNumber);
            $prefixCode ='';
            for ($i=$length;$i<2;$i++){
                $prefixCode .= '0';
            }
            $generatedCode = $prefix.$prefixCode.$newNumber;
        }

        $response = compact('generatedCode');
        return response()->json($response);
    }

    public function store(FabricRequest $request)
    {
        Fabric::create($request->only(['kode','description']));
        return redirect()->route('fabric.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Fabric $fabric)
    {
        return response()->json($fabric);
    }

    public function update(FabricRequest $request, Fabric $fabric)
    {
       Fabric::where('id',$fabric->id)->update($request->only(['kode','description']));
        return redirect()->route('fabric.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Fabric $fabric)
    {
        Fabric::destroy($fabric->id);
        return redirect()->route('fabric.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
