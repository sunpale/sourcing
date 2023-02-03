<?php
namespace App\Traits;

use App\Observers\UserInputObserver;

trait UserInput {
    public static function bootUserInput()
    {
        static::observe(UserInputObserver::class);
    }
}
