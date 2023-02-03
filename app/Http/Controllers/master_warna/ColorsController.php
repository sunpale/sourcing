<?php

namespace App\Http\Controllers\master_warna;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\master_warna\Color;
use Illuminate\Http\Request;

class ColorsController extends Controller
{
    public function index()
    {
        $color = Color::select(['id','kode','description'])->get();
        $data = ['dataWarna'=>$color];
        return view('master_warna.md',$data);
    }

    public function store(ColorRequest $request)
    {
        Color::create($request->only(['kode','description']));
        return redirect()->route('warna.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Color $warna)
    {
        return response()->json($warna);
    }

    public function update(ColorRequest $request, Color $warna)
    {
        Color::where('id',$warna->id)->update($request->only(['kode','description']));
        return redirect()->route('warna.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Color $warna)
    {
        Color::destroy($warna->id);
        return redirect()->route('warna.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
