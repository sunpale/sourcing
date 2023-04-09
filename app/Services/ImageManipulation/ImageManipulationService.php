<?php

namespace App\Services\ImageManipulation;

use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

interface ImageManipulationService{
    public function move_image(MediaCollection $image,bool $withThumbnail = false);

    public function move_thumbnail(MediaCollection $image);
}
