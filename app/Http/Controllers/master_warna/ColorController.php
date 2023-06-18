<?php

namespace App\Http\Controllers\master_warna;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_warna\ColorRequest;
use App\Models\master_warna\Color;

class ColorController extends Controller
{
    public function index()
    {
        $color = Color::select(['id','kode','description'])->get();
        return view('master_warna.md',compact('color'));
    }

    public function store(ColorRequest $request)
    {
        Color::create($request->only(['kode','description']));
        return redirect()->route('master-warna.warna.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Color $warna)
    {
        return response()->json($warna);
    }

    public function update(ColorRequest $request, Color $warna)
    {
        $warna->update($request->only(['kode','description']));
        return redirect()->route('master-warna.warna.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Color $warna)
    {
        $warna->delete();
        return redirect()->route('master-warna.warna.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
