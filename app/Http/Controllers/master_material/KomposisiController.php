<?php

namespace App\Http\Controllers\master_material;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_material\KomposisiRequest;
use App\Models\master_material\Komposisi;

class KomposisiController extends Controller
{
    public function index()
    {
        $komposisi = Komposisi::select(['id','komposisi','keterangan'])->get();
        $data = [
            'dataKomposisi' => $komposisi
        ];
        return view('master_rm.komposisi.main',$data);
    }

    public function store(KomposisiRequest $request)
    {
        Komposisi::create($request->only(['komposisi','keterangan']));
        return redirect()->route('master-rm.komposisi.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Komposisi $komposisi)
    {
        return response()->json($komposisi);
    }

    public function update(KomposisiRequest $request, Komposisi $komposisi)
    {
        Komposisi::where('id',$komposisi->id)->update($request->only(['komposisi','keterangan']));
        return redirect()->route('master-rm.komposisi.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Komposisi $komposisi)
    {
        Komposisi::destroy($komposisi->id);
        return redirect()->route('master-rm.komposisi.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
