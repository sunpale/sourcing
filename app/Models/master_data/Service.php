<?php

namespace App\Models\master_data;

use App\Models\BOM\Bom_detail_service;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use UserInput, CustomSoftDelete, SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['name','remarks'];

    public function BomDetailService(): HasMany
    {
        return $this->hasMany(Bom_detail_service::class);
    }
}
