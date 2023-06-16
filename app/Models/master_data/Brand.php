<?php

namespace App\Models\master_data;

use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use UserInput, CustomSoftDelete, SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}
    protected $fillable = ['kode','brand'];

    public function getFullBrandAttribute(): string
    {
        return $this->kode.' - '.$this->brand;
    }
}
