<?php

namespace App\Observers;

use Auth;
use Illuminate\Database\Eloquent\Model;

class UserInputObserver
{
    public function creating(Model $model){
        $model->created_by = Auth::user()->id;
        $model->updated_by = Auth::user()->id;
    }

    public function updating(Model $model){
        $model->updated_by = Auth::user()->id;
        if ($model->forceDeleting) {
            $model->deleted_by = Auth::user()->id;
        }
    }
}
