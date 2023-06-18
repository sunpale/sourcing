<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_data\SizeRequest;
use App\Models\master_data\Size;

class SizeController extends Controller
{
    public function index()
    {
        $size = Size::select(['id','size','remarks'])->get();
        return view('master_data.article-size.main',compact('size'));
    }

    public function store(SizeRequest $request)
    {
        Size::create($request->only(['size','remarks']));
        return redirect()->route('article-size.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Size $article_size)
    {
        return response()->json($article_size);
    }

    public function update(SizeRequest $request, Size $article_size)
    {
        $article_size->update($request->only(['size','remarks']));
        return redirect()->route('article-size.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Size $article_size)
    {
        $article_size->delete();
        return redirect()->route('article-size.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
