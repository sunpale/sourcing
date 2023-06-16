<?php

namespace App\Http\Controllers\master_warna;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_warna\PantoneRequest;
use App\Models\master_warna\Pantone;

class PantoneController extends Controller
{
    public function index()
    {
        $pantone = Pantone::select(['id','kode','pantone'])->get();
        return view('master_warna.pantone',compact('pantone'));
    }

    public function store(PantoneRequest $request)
    {
        Pantone::create($request->only(['kode','pantone']));
        return redirect()->route('master-warna.pantone.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Pantone $pantone)
    {
        return response()->json($pantone);
    }

    public function update(PantoneRequest $request, Pantone $pantone)
    {
        Pantone::where('id',$pantone->id)->update($request->only(['kode','pantone']));
        return redirect()->route('master-warna.pantone.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Pantone $pantone)
    {
        Pantone::destroy($pantone->id);
        return redirect()->route('master-warna.pantone.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
