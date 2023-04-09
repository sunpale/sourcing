<?php

namespace App\Http\Controllers\BOM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\BOM\Article;
use App\Models\CustomMedia;
use App\Models\master_data\Brand;
use App\Models\master_warna\Pantone;
use App\Services\ImageManipulation\ImageManipulationService;
use Exception;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Yajra\DataTables\Facades\DataTables;

class ArticlesController extends Controller
{
    private ImageManipulationService $imageManipulation;
    public function __construct(ImageManipulationService $imageManipulation)
    {
        $this->imageManipulation = $imageManipulation;
    }

    public function index()
    {
        $articles = Article::all();
        return view('bom.article.main',compact('articles'));
    }

    public function create(){
        $brand = Brand::where('kode','!=',99)->pluck('brand','id');
        $pantone = Pantone::all()->pluck('full_pantone','id');
        return view('bom.article.create',compact('brand','pantone'));
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function store(ArticleRequest $request)
    {
        $article = Article::create($request->except('_token','number','img_file'));
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $image = $request->file('img_file');
            $filename = $request->kode.'.'.$image->extension();
            $article->addMediaFromRequest('img_file')->usingName($request->kode)->usingFileName($filename)->storingConversionsOnDisk('media-thumb')->toMediaCollection('articles');
        }
        return redirect()->route('bom.articles.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    /**
     * @throws Exception
     */
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
        return redirect()->route('bom.articles.index');
    }

    public function show(Article $article)
    {
        return $article;
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->validated());

        return $article;
    }

    public function destroy(Article $article)
    {
        Article::destroy($article->id);
        $image = $article->getMedia('articles');
        if($image->count() >0){
            CustomMedia::where('model_id',$article->id)->update(['collection_name' => 'media-archived','disk' => 'media-archived','conversions_disk' => 'media-archived']);
            $this->imageManipulation->move_image($image,true);
        }
        return redirect()->route('bom.articles.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
