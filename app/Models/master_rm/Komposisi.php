<?php

namespace App\Models\master_rm;

use App\Traits\CustomSoftDeleteTrait;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Komposisi extends Model
{
    Use UserInput,CustomSoftDeleteTrait,SoftDeletes {CustomSoftDeleteTrait::runSoftDelete insteadof SoftDeletes;}

    protected $table = 'komposisi';
    protected $fillable = ['id','komposisi','keterangan'];

}
