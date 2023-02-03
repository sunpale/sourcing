<?php

namespace App\Models\master_rm;

use App\Traits\CustomSoftDeleteTrait;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fabric extends Model
{
    use UserInput,CustomSoftDeleteTrait,SoftDeletes {CustomSoftDeleteTrait::runSoftDelete insteadof SoftDeletes;}
    protected $fillable = ['kode','description'];
}
