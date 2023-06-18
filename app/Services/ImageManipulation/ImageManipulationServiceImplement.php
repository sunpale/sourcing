<?php

namespace App\Services\ImageManipulation;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

class ImageManipulationServiceImplement implements ImageManipulationService{
    public static function move_image(MediaCollection $image, bool $withThumbnail = false): void
    {
        $sourcePath = explode('/',config('filesystems.disks.media.root'));
        $destinationPath = explode('/',config('filesystems.disks.media-archived.root'));
        $collection = $image->collectionName;
        $fileName = $image[0]->file_name;
        Storage::move($sourcePath[1].'/'.$sourcePath[2].'/'.$collection.'/'.$fileName,$destinationPath[1].'/'.$destinationPath[2].'/'.$collection.'/'.$fileName);
        if ($withThumbnail)
            self::move_thumbnail($image);
    }

    public static function move_thumbnail(MediaCollection $image): void
    {
        $sourcePath = explode('/',config('filesystems.disks.media-thumb.root'));
        $destinationPath = explode('/',config('filesystems.disks.media-archived.root'));
        $collection = $image->collectionName;
        $fileName = $image[0]->name;
        $extension = explode('.',$image[0]->file_name);
        Storage::move($sourcePath[1].'/'.$sourcePath[2].'/'.$collection.'/'.$fileName.'-thumb.'.$extension[count($extension)-1],
            $destinationPath[1].'/'.$destinationPath[2].'/'.$collection.'/'.$fileName.'-thumb.'.$extension[count($extension)-1]);
    }

    public static function rename_image(MediaCollection $image,string $new_name): void
    {
        $collection = $image->collectionName;
        $extension = $image[0]->custom_properties['extension'];
        $diskName = $image[0]->disk;
        $conversionDisk = $image[0]->conversions_disk;
        $fileName = $image[0]->name;
        Storage::disk($diskName)->move($collection.'/'.$fileName.'.'.$extension,$collection.'/'.$new_name.'.'.$extension);
        Storage::disk($conversionDisk)->move($collection.'/'.$fileName.'-thumb.'.$extension,$collection.'/'.$new_name.'-thumb.'.$extension);
    }

    public static function delete_image(MediaCollection $image): void
    {
        $collection = $image->collectionName;
        $extension = $image[0]->custom_properties['extension'];
        $diskName = $image[0]->disk;
        $conversionDisk = $image[0]->conversions_disk;
        $fileName = $image[0]->name;
        Storage::disk($diskName)->delete($collection.'/'.$fileName.'.'.$extension);
        Storage::disk($conversionDisk)->delete($collection.'/'.$fileName.'-thumb.'.$extension);
    }
}
