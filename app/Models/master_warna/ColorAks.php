<?php

namespace App\Models\master_warna;

use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColorAks extends Model
{
    use UserInput, CustomSoftDelete, SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}
    protected $fillable = ['kode','color_desc','remarks'];

    public function getFullColorAttribute(): string
    {
        return $this->kode.' - '.$this->color_desc;
    }
}
