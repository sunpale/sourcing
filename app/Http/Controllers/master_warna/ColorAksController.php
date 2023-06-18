<?php

namespace App\Http\Controllers\master_warna;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_warna\ColorAksRequest;
use App\Models\master_warna\ColorAks;
use App\Services\CodeGenerator\code_type;
use App\Services\CodeGenerator\CodeGeneratorServiceImplement;

class ColorAksController extends Controller
{
    public function index()
    {
        $color = ColorAks::select(['id','kode','color_desc','remarks'])->get();
        return view('master_warna.aksesoris',compact('color'));
    }

    private function generateCode(): string
    {
        return $this->validateCodeGenerated(CodeGeneratorServiceImplement::generate_random_code(code_type::NUMERIC, 3));
    }

    private function validateCodeGenerated(string $kode): string
    {
        if (ColorAks::where('kode',$kode)->exists()){
            $this->generateCode();
        }
        return $kode;
    }

    public function store(ColorAksRequest $request)
    {
        $data = $request->except(['_token','number']);
        $data['kode'] = $this->generateCode();
        ColorAks::create($data);
        return redirect()->route('master-warna.warna-aksesoris.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(ColorAks $warna_aksesori)
    {
        return response()->json($warna_aksesori);
    }


    public function update(ColorAksRequest $request, ColorAks $warna_aksesori)
    {
        $warna_aksesori->update($request->except(['_token','number','_method']));
        return redirect()->route('master-warna.warna-aksesoris.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(ColorAks $warna_aksesori)
    {
        $warna_aksesori->delete();
        return redirect()->route('master-warna.warna-aksesoris.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
