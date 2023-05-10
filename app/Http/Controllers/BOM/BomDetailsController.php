<?php

namespace App\Http\Controllers\BOM;

use App\Http\Controllers\Controller;
use App\Models\BOM\Bom;
use App\Models\BOM\Bom_detail;

class BomDetailsController extends Controller
{
    public function findBom(Bom_detail $bom_detail){
        dd($bom_detail->id);
        $result = Bom_detail::select(['material_id','product_group_id','size_id','ratio','cons'])->where('id',$bom->id)->get();
        return response()->json(compact('result'));

        /*$result = $article->with(['pantone:id,kode,pantone','brand:id,brand'])->select(['kode','modul','name','pantone_id','brand_id','designer'])
            ->where('id',$article->id)->get();
        $image = $article->getFirstMediaUrl('articles');
        return response()->json(compact('result','image'));*/
    }
}
