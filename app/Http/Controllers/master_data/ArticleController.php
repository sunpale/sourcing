<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_data\ArticleRequest;
use App\Models\CustomMedia;
use App\Models\master_data\Article;
use App\Models\master_data\Brand;
use App\Models\master_warna\Pantone;
use App\Services\ImageManipulation\ImageManipulationServiceImplement;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('master_data.article.main',compact('articles'));
    }

    public function create(){
        $brand = Brand::where('kode','!=',00)->pluck('brand','id');
        $pantone = Pantone::all()->pluck('full_pantone','id');
        $editMode = false;
        return view('master_data.article.create',compact('brand','pantone','editMode'));
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(ArticleRequest $request)
    {
        $article = Article::create($request->except('_token','number','img_file'));
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $image = $request->file('img_file');
            $filename = $request->kode.'.'.$image->extension();
            $article->addMediaFromRequest('img_file')->usingName($request->kode)->usingFileName($filename)->storingConversionsOnDisk('media-thumb')->withCustomProperties(['extension' => $image->extension()])->toMediaCollection('articles');
        }
        return redirect()->route('articles.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function data(){
        if(request()->ajax()){
            $query = Article::select(['id','kode','name','pantone_id','brand_id','modul','designer'])
                ->with(['pantone:id,pantone','brand:id,brand']);
            return DataTables::eloquent($query)->addIndexColumn()->addColumn('responsive',function (){return '';})
                ->addColumn('image',function ($row){
                    if($row->getMedia('articles')->count() > 0)
                        return '<a  id="image-popup_'.$row->id.'" class="btn btn-xs btn-primary" href="'.$row->getFirstMediaUrl('articles').'">show Image</a>';
                    return '';
                })
                ->addColumn('action',function ($row){
                    return '<div class="dropdown d-inline-block"><button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-equalizer-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a id="btnedit" href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" class="dropdown-item" onclick=edit("'.$row->id.'")><i class="ri-edit-fill"></i> Edit Data</a></li><li><a id="btnhapus" href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick=hapus("'.$row->id.'")><i class="ri-close-circle-fill"></i> Hapus Data</a></li></ul></div>';
                })->rawColumns(['image','action'])->make();
        }
        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        $brand = Brand::where('kode','!=',00)->pluck('brand','id');
        $pantone = Pantone::all()->pluck('full_pantone','id');
        $editMode = true;
        return view('master_data.article.create',compact('brand','pantone','article','editMode'));
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->except('_token','number','img_file','_method'));
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $image = $request->file('img_file');
            $filename = $request->kode.'.'.$image->extension();
            if(strcmp($request->old_kode,$request->kode)!=0){
                $media = $article->getMedia('articles');
                if ($media->count() > 0){
                    ImageManipulationServiceImplement::delete_image($media);
                }
            }
            $article->media()->delete();
            $article->addMediaFromRequest('img_file')->usingName($request->kode)->usingFileName($filename)->storingConversionsOnDisk('media-thumb')->withCustomProperties(['extension' => $image->extension()])->toMediaCollection('articles');

        }else{
            $image = $article->getMedia('articles');
            if ($image->count() > 0){
                $updateNameFile = CustomMedia::where('model_id',$article->id)->update(['name' => $request->kode,'file_name' => $request->kode.'.'.$image[0]->custom_properties['extension']]);
                if ($updateNameFile)
                    ImageManipulationServiceImplement::rename_image($image,$request->kode);
            }
        }
        return redirect()->route('articles.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Article $article)
    {
        $article->delete();
        $image = $article->getMedia('articles');
        if($image->count() >0){
            CustomMedia::where('model_id',$article->id)->update(['collection_name' => 'media-archived','disk' => 'media-archived','conversions_disk' => 'media-archived']);
            ImageManipulationServiceImplement::move_image($image,true);
        }
        return redirect()->route('articles.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
