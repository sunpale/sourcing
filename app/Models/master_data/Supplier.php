<?php

namespace App\Models\master_data;

use App\Models\master_aks\ProductGroup;
use App\Models\master_rm\Material;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use UserInput,CustomSoftDelete,SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['kode','name','type','product_group_id','address'];

    public function ProductGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class,'product_group_id','id');
    }

    public function Material(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
