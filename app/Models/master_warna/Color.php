<?php

namespace App\Models\master_warna;

use App\Traits\CustomSoftDeleteTrait;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use UserInput,CustomSoftDeleteTrait,SoftDeletes {CustomSoftDeleteTrait::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['kode','description'];
}
