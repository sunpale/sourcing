<?php

namespace App\Models\master_data;

use App\Models\BOM\Bom_detail;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use UserInput,CustomSoftDelete, SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['size','remarks'];

    public function BomDetail(): HasMany
    {
        return $this->hasMany(Bom_detail::class);
    }
}
