<?php

namespace App\Http\Controllers\master_material;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_material\ProductGroupRequest;
use App\Models\master_material\ProductGroup;

class ProductGroupController extends Controller
{
    public function index()
    {
        $group = ProductGroup::select(['id','kode','group','type','remarks'])->get();
        return view('master_material.product_group.main',compact('group'));
    }

    public function store(ProductGroupRequest $request)
    {
        ProductGroup::create($request->only(['kode','type','group','remarks']));
        return redirect()->route('master-material.product-group.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(ProductGroup $productGroup)
    {
        return response()->json($productGroup);
    }

    public function update(ProductGroupRequest $request, ProductGroup $productGroup)
    {
        $productGroup->update($request->only(['kode','type','group','remarks']));
        return redirect()->route('master-material.product-group.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(ProductGroup $productGroup)
    {
        $productGroup->delete();
        return redirect()->route('master-material.product-group.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
