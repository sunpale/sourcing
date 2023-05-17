<?php

namespace App\Models\BOM;

use App\Models\master_data\Article;
use App\Traits\BomApprovedLog;
use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Cog\Flag\Traits\Classic\HasApprovedFlag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasShortflakePrimary;

class Bom extends Model
{
    use HasApprovedFlag,BomApprovedLog,HasShortflakePrimary,UserInput,CustomSoftDelete, SoftDeletes{CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}
    protected $fillable = ['kode','article_id','remarks','revision','approved','approved_by','items','status'];

    public function Article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
