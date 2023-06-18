<?php

namespace App\Models\master_warna;

use App\Models\master_data\Article;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pantone extends Model
{
    use UserInput, CustomSoftDelete, SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['kode','pantone'];

    public function getFullPantoneAttribute(): string
    {
        return $this->kode.' - '.$this->pantone;
    }

    public function Article(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
