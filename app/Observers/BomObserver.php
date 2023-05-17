<?php

namespace App\Observers;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class BomObserver
{
    public function updating(Model $model){
        $model->approved_at = Date::now();
        $model->approved_by = Auth::user()->id;
    }
}
