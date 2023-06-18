<?php

namespace App\Models\master_data;

use App\Models\master_material\ProductGroup;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use UserInput, CustomSoftDelete, SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['kode','name','type','product_group_id','address','country','pic','phone','email'];

    public function ProductGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class,'product_group_id','id');
    }
}
