<?php

namespace App\Models\master_warna;

use App\Models\master_rm\Material;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use UserInput,CustomSoftDelete,SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['kode','description'];

    public function getFullDescriptionAttribute(): string
    {
        return $this->kode.' - '.$this->description;
    }

    public function Material(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
