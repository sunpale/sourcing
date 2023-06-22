<?php

namespace App\Models\master_material;

use App\Models\master_data\Brand;
use App\Models\master_data\Measure;
use App\Models\master_data\Supplier;;
use App\Models\master_warna\Color;
use App\Models\master_warna\ColorAks;
use App\Models\User;
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

class Material extends Model implements HasMedia
{
    use HasShortflakePrimary, UserInput, InteractsWithMedia, CustomSoftDelete, SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    public $incrementing = false;
    protected $fillable = ['kode','kode_infor','fabric_id','color_id','brand_id','supplier_id','pantone_id','product_group_id','color_aks_id','komposisi_id','item_name','item_desc','gramasi','lebar','susut','finish','lead_time','moq','moq_color','ppn','measure_id','unit_price','component'];

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $ImageInstance = Image::load($media->getPath());
        $this->addMediaConversion('thumb')->width($ImageInstance->getWidth()*0.1)->sharpen(10);
    }

    public function Fabric(): BelongsTo
    {
        return $this->belongsTo(Fabric::class);
    }

    public function Color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function Supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function Komposisi(): BelongsTo
    {
        return $this->belongsTo(Komposisi::class);
    }

    public function Measure(): BelongsTo
    {
        return $this->belongsTo(Measure::class);
    }

    public function ProductGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function ColorAks() : BelongsTo
    {
        return $this->belongsTo(ColorAks::class);
    }

    public function User() : BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }
}
