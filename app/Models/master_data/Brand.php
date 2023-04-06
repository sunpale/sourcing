<?php

namespace App\Models\master_data;

use App\Models\BOM\Article;
use App\Models\master_rm\Material;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use UserInput,CustomSoftDelete,SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['kode','brand'];

    public function getFullBrandAttribute(): string
    {
        return $this->kode.' - '.$this->brand;
    }

    public function Material(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function Article(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
