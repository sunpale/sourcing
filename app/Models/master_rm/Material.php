<?php

namespace App\Models\master_rm;

use App\Models\BOM\Bom_detail;
use App\Models\master_aks\ProductGroup;
use App\Models\master_data\Brand;
use App\Models\master_data\Measure;
use App\Models\master_data\Supplier;
use App\Models\master_warna\Color;
use App\Models\master_warna\ColorAks;
use App\Models\User;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use UserInput,CustomSoftDelete,SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $primaryKey = 'kode';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['kode','kode_infor','fabric_id','color_id','brand_id','supplier_id','pantone_id','product_group_id','color_aks_id','komposisi_id','item_name','item_desc','gramasi','lebar','susut','finish','lead_time','moq','moq_color','ppn','measure_id','image_path','image_name'];

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

    public function BomDetail() :HasMany
    {
        return $this->hasMany(Bom_detail::class,'material_id','id');
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->format('d/m/Y H:i');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('d/m/Y H:i');
    }

    public function getDeletedAtAttribute($value){
        return Carbon::parse($value)->format('d/m/Y H:i');
    }
}
