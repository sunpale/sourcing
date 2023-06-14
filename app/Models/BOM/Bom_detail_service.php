<?php

namespace App\Models\BOM;

use App\Models\master_data\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kra8\Snowflake\HasShortflakePrimary;

class Bom_detail_service extends Model
{
    use HasShortflakePrimary;
    public $timestamps = false;
    protected $fillable = ['id','bom_id','service_id','remarks','cons','price'];

    public function Service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
