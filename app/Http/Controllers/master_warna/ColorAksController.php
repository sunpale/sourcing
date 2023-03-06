<?php

namespace App\Http\Controllers\master_warna;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorAksRequest;
use App\Models\master_warna\ColorAks;
use Illuminate\Http\Request;

class ColorAksController extends Controller
{
    public function index()
    {
        $colorAks = ColorAks::select(['id','kode','color_desc','remarks'])->get();
        $data = [
            'dataWarna' => $colorAks
        ];
        return view('master_warna.aksesoris',$data);
    }

    private function generateCode(): string
    {
        $stringList = '0123456789';
        $code = '';
        while (strlen($code) < 3){
            $position = rand(0,strlen($stringList)-1);
            $character = $stringList[$position];
            $code .= $character;
        }
       return $this->validateCodeGenerated($code);
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
        ColorAks::where('id',$warna_aksesori->id)->update($request->except(['_token','number','_method']));
        return redirect()->route('master-warna.warna-aksesoris.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(ColorAks $warna_aksesori)
    {
        ColorAks::destroy($warna_aksesori->id);
        return redirect()->route('master-warna.warna-aksesoris.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
