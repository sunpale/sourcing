<?php

namespace App\Services\ImageManipulation;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

class ImageManipulationServiceImplement implements ImageManipulationService{
    public function move_image(MediaCollection $image, bool $withThumbnail = false): void
    {
        $sourcePath = explode('/',config('filesystems.disks.media.root'));
        $destinationPath = explode('/',config('filesystems.disks.media-archived.root'));
        $collection = $image->collectionName;
        $fileName = $image[0]->file_name;
        Storage::move($sourcePath[1].'/'.$sourcePath[2].'/'.$collection.'/'.$fileName,$destinationPath[1].'/'.$destinationPath[2].'/'.$collection.'/'.$fileName);
        if ($withThumbnail)
            $this->move_thumbnail($image);
    }

    public function move_thumbnail(MediaCollection $image): void
    {
        $sourcePath = explode('/',config('filesystems.disks.media-thumb.root'));
        $destinationPath = explode('/',config('filesystems.disks.media-archived.root'));
        $collection = $image->collectionName;
        $fileName = $image[0]->name;
        $extension = explode('.',$image[0]->file_name);
        Storage::move($sourcePath[1].'/'.$sourcePath[2].'/'.$collection.'/'.$fileName.'-thumb.'.$extension[count($extension)-1],
            $destinationPath[1].'/'.$destinationPath[2].'/'.$collection.'/'.$fileName.'-thumb.'.$extension[count($extension)-1]);
    }
}
