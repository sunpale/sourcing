<?php

namespace App\Models;

use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class CustomMedia extends Media
{
    use HasShortflakePrimary;
}
