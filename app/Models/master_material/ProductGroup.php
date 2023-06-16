<?php

namespace App\Models\master_material;

use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroup extends Model
{
    use UserInput, CustomSoftDelete, SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['kode','type','group','remarks'];

    public function getFullGroupAttribute(): string
    {
        return $this->kode.' - '.$this->group;
    }
}
