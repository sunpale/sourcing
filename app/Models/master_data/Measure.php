<?php

namespace App\Models\master_data;

use App\Models\master_material\Material;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measure extends Model
{
    use UserInput, CustomSoftDelete, SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['kode','measure_name'];

    public function Material(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
