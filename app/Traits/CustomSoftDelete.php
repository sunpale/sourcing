<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
trait CustomSoftDelete {
    protected function runSoftDelete(): void
    {
        $keyName = $this->getKeyName();
        $keyValue = $this->getKey();
        $tableName = $this->getTable();

        if (key_exists('deleted_by', $this->attributes)) {
            $updateColumns = [$this->getDeletedAtColumn() => $this->freshTimestamp(), 'deleted_by' => Auth::user()->id];
        } else {
            $updateColumns = [$this->getDeletedAtColumn() => $this->freshTimestamp()];
        }

        // Do not use the model to do the update, as it will also update the updated_at column.
        DB::table($tableName)
            ->where($keyName, '=', $keyValue)
            ->update($updateColumns);
    }
}
