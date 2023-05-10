<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\CustomMedia;
use App\Models\master_data\Article;
use App\Models\master_data\Brand;
use App\Models\master_warna\Pantone;
use App\Services\ImageManipulation\ImageManipulationService;
use Exception;
use Illuminate\Http\Request;
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
        return view('master_data.article.main',compact('articles'));
    }

    public function create(){
        $brand = Brand::where('kode','!=',99)->pluck('brand','id');
        $pantone = Pantone::all()->pluck('full_pantone','id');
        $editMode = false;
        return view('master_data.article.create',compact('brand','pantone','editMode'));
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
        return redirect()->route('articles.index')->with('success',config('constants.SUCCESS_SAVE'));
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
        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        $brand = Brand::where('kode','!=',99)->pluck('brand','id');
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
        Article::where('id',$article->id)->update($request->except('_token','number','img_file','_method'));
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $image = $request->file('img_file');
            $filename = $request->kode.'.'.$image->extension();
            $article->media()->delete();
            $article->addMediaFromRequest('img_file')->usingName($request->kode)->usingFileName($filename)->storingConversionsOnDisk('media-thumb')->toMediaCollection('articles');
        }
        return redirect()->route('articles.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Article $article)
    {
        Article::destroy($article->id);
        $image = $article->getMedia('articles');
        if($image->count() >0){
            CustomMedia::where('model_id',$article->id)->update(['collection_name' => 'media-archived','disk' => 'media-archived','conversions_disk' => 'media-archived']);
            $this->imageManipulation->move_image($image,true);
        }
        return redirect()->route('articles.index')->with('success',config('constants.SUCCESS_DELETE'));
    }

    public function getArticles(Request $request){
        /*get data pencarian dan jumlah halaman dari komponen select2*/
        $search = $request->search;
        $halaman = $request->page;
        $searchData = empty($search) ? "" : $search;
        /*$type = $request->type;*/
        /*end*/
        /*Set jumlah data per halaman*/
        $pageLoad = 25;
        /*End*/
        /*Cek jumlah halaman, kemudian dikurang satu (offset data di mulai dari 0)*/
        if($halaman==1){
            $page=0;
        }else{
            /*Jika halaman lebih dari 1, maka setelah dikurang satu dikalikan jumlah data per halaman untuk mendapatkan data offset halaman berikutnya*/
            $page=($halaman-1)*$pageLoad;
            /*end*/
        }
        /*end*/
        /*Memanggil data dan jumlah data dari database*/
        $dataItem=Article::select(['id','kode','name'])->where('kode','LIKE','%'.$searchData.'%')->limit($pageLoad)->offset($page)->get();
        $dataCount=Article::select(['id','kode','name'])->where('kode','LIKE','%'.$searchData.'%')->count();
        /*End*/

        /*Mengubah hasil data dari database sesuai dengan format dari select2*/
        $result=array();
        foreach ($dataItem as $item){
            $result[] = array("id" => $item->id,"text"=>$item->kode.' - '.$item->name);
        }
        $resultQuery['items']=$result;
        $resultQuery['total_count']=$dataCount;
        /*End*/
        return response()->json($resultQuery);
    }

    public function findArticle(Article $article){
        $result = $article->with(['pantone:id,kode,pantone','brand:id,brand'])->select(['kode','modul','name','pantone_id','brand_id','designer'])
            ->where('id',$article->id)->get();
        $image = $article->getFirstMediaUrl('articles');
        return response()->json(compact('result','image'));
    }
}
