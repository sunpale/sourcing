<?php

namespace App\Services\ImageManipulation;

use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

interface ImageManipulationService{
    public static function move_image(MediaCollection $image,bool $withThumbnail = false);

    public static function move_thumbnail(MediaCollection $image);

    public static function rename_image(MediaCollection $image, string $new_name);

    public static function delete_image(MediaCollection $image);
}
