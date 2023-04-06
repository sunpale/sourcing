<?php

namespace App\Models\BOM;

use App\Models\master_data\Brand;
use App\Models\master_warna\Pantone;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use HasShortflakePrimary,UserInput,InteractsWithMedia,CustomSoftDelete, SoftDeletes{CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}
    protected $fillable = ['kode','name','pantone_id','brand_id','modul','designer'];
    public $incrementing = false;

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $ImageInstance = Image::load($media->getPath());
        $this->addMediaConversion('thumb')->width($ImageInstance->getWidth()*0.1)->sharpen(10);
    }

    public function Pantone(): BelongsTo
    {
        return $this->belongsTo(Pantone::class);
    }

    public function Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
