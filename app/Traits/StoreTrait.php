<?php
namespace App\Traits;

use App\Models\master_material\Material;
use App\Services\CodeGenerator\CodeGeneratorServiceImplement;
use App\Services\ImageManipulation\ImageManipulationServiceImplement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

trait StoreTrait {
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    protected function storeImplementation(FormRequest $request, string $collection, string $route): RedirectResponse
    {
        $data = $request->except(['_token','number','img_file']);
        $kodeGenerated = $request->number;
        $prefix = substr($kodeGenerated,0,strlen($kodeGenerated)-4);
        $kode = $this->createCode($prefix);
        $data['kode'] = $kode;
        $data['unit_price'] = str_replace('.','',$request->unit_price);
        $material = Material::create($data);
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $image = $request->file('img_file');
            $filename = $kode.'.'.$image->extension();
            $material->addMediaFromRequest('img_file')->usingName($kode)->usingFileName($filename)->storingConversionsOnDisk('media-thumb')->withCustomProperties(['extension' => $image->extension()])->toMediaCollection($collection);
        }
        return redirect()->route($route)->with(config('constants.SUCCESS_SAVE'));
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    protected function updateImplementation(FormRequest $request, string $collection, string $route, Material $model): RedirectResponse
    {
        $data = $request->except(['_token','_method','number','img_file']);
        $kodeGenerated = $request->number;
        $prefixOldKode = substr($model->kode,0,strlen($model->kode)-4);
        $prefix = substr($kodeGenerated,0,strlen($kodeGenerated)-4);
        $kode = strcmp($prefix,$prefixOldKode) == 0 ? $model->kode : $this->createCode($prefix);
        $data['kode'] = $kode;
        $data['unit_price'] = str_replace('.','',$request->unit_price);

        $model->update($data);

        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()){
            $image = $request->file('img_file');
            $filename = $kode.'.'.$image->extension();
            /*cek apakah kodenya berbeda, jika berbeda gambar sebelumnya akan dihapus dan diganti dengan gambar yang baru*/
            if(strcmp($request->old_kode,$kode)!=0){
                $media = $model->getMedia($collection);
                if ($media->count() > 0){
                    ImageManipulationServiceImplement::delete_image($media);
                }
            }
            $model->media()->delete();
            $model->addMediaFromRequest('img_file')->usingName($kode)->usingFileName($filename)->storingConversionsOnDisk('media-thumb')->withCustomProperties(['extension'=>$image->extension()])->toMediaCollection($collection);
        }else{
            $image = $model->getMedia($collection);
            if ($image->count() > 0) {
                $updateNameFile = $model->media()->update(['name' => $kode,'file_name'=>$kode.'.'.$image[0]->custom_properties['extension']]);
                if ($updateNameFile)
                    ImageManipulationServiceImplement::rename_image($image,$kode);
            }
        }
        return redirect()->route($route)->with('success',config('constants.SUCCESS_UPDATE'));

    }

    private function createCode(string $prefix): string
    {
        $lastKode = Material::select('kode')->where('kode','LIKE','%'.$prefix.'%')->orderBy('created_at','desc')->withTrashed()->get();
        return CodeGeneratorServiceImplement::generate($lastKode,$prefix,8,4,'kode');
    }
}
