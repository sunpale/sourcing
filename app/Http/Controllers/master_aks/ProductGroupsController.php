<?php

namespace App\Http\Controllers\master_aks;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductGroupRequest;
use App\Models\master_aks\ProductGroup;
use Illuminate\Http\Request;

class ProductGroupsController extends Controller
{
    public function index()
    {
        $group = ProductGroup::select(['id','group','remarks'])->get();
        $data = ['productGroup'=>$group];
        return view('master_aks.product_group.main',$data);
    }

    public function store(ProductGroupRequest $request)
    {
        ProductGroup::create($request->only(['group','remarks']));
        return redirect()->route('product-group.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(ProductGroup $productGroup)
    {
        return response()->json($productGroup);
    }

    public function update(ProductGroupRequest $request, ProductGroup $productGroup)
    {
        ProductGroup::where('id',$productGroup->id)->update($request->only(['group','remarks']));
        return redirect()->route('product-group.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(ProductGroup $productGroup)
    {
        ProductGroup::destroy($productGroup->id);
        return redirect()->route('product-group.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
