<?php

namespace App\Models\BOM;

use App\Models\master_aks\ProductGroup;
use App\Models\master_data\Size;
use App\Models\master_rm\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kra8\Snowflake\HasShortflakePrimary;

class Bom_detail extends Model
{
    use HasShortflakePrimary;
    public $timestamps = false;
    protected $fillable = ['bom_id','material_id','size_id','ratio','cons','product_group_id','price'];

    public function Material() :BelongsTo
    {
        return $this->belongsTo(Material::class,'material_id','id');
    }

    public function Size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function ProductGroup() :BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }
}
