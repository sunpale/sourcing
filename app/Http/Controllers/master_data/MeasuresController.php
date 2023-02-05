<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeasureRequest;
use App\Models\master_data\Measure;
use Illuminate\Http\Request;

class MeasuresController extends Controller
{
    public function index()
    {
        $uom = Measure::select(['id','kode','measure_name'])->get();
        $data = ['dataUom'=>$uom];
        return view('master_data.uom.main',$data);
    }

    public function store(MeasureRequest $request)
    {
        Measure::create($request->only(['kode','measure_name']));
        return redirect()->route('measure.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Measure $measure)
    {
        return response()->json($measure);
    }

    public function update(MeasureRequest $request, Measure $measure)
    {
        Measure::where('id',$measure->id)->update($request->only(['kode','measure_name']));
        return redirect()->route('measure.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Measure $measure)
    {
        Measure::destroy($measure->id);
        return redirect()->route('measure.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
