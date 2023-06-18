<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_data\MeasureRequest;
use App\Models\master_data\Measure;

class MeasureController extends Controller
{
    public function index()
    {
        $measure = Measure::select(['id','kode','measure_name'])->get();
        return view('master_data.uom.main',compact('measure'));
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
        $measure->update($request->only(['kode','measure_name']));
        return redirect()->route('measure.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Measure $measure)
    {
        $measure->delete();
        return redirect()->route('measure.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
