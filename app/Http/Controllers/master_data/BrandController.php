<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_data\BrandRequest;
use App\Models\master_data\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::select(['id','kode','brand'])->get();
        return view('master_data.brand.main',compact('brands'));
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
        $brand->update($request->only(['kode','brand']));
        return redirect()->route('brands.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
