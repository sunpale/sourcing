<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\master_data\Brand;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function index()
    {
        $brand = Brand::select(['id','kode','brand'])->get();
        $data = ['dataBrand' => $brand];

        return view('master_data.brand.main',$data);
    }

    public function store(BrandRequest $request)
    {
        Brand::create($request->only(['kode','brand']));
        return redirect()->route('brands.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Brand $brand)
    {
        return response()->json($brand);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        Brand::where('id',$brand->id)->update($request->only(['kode','brand']));
        return redirect()->route('brands.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Brand $brand)
    {
        Brand::destroy($brand->id);
        return redirect()->route('brands.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
