<?php

namespace App\Traits;

use App\Observers\BomObserver;

trait BomApprovedLog
{
    public static function bootBomApprovedLog(){
        static::observe(BomObserver::class);
    }
}
