<?php

namespace App\Models\master_rm;

use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Komposisi extends Model
{
    Use UserInput,CustomSoftDelete,SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $table = 'komposisi';
    protected $fillable = ['id','komposisi','keterangan'];

    public function Material(): HasMany
    {
        return $this->hasMany(Material::class);
    }

}
