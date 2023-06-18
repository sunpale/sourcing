<?php

namespace App\Providers;

use App\Services\ImageManipulation\ImageManipulationService;
use App\Services\ImageManipulation\ImageManipulationServiceImplement;
use Illuminate\Support\ServiceProvider;

class ImageManipulationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImageManipulationService::class,ImageManipulationServiceImplement::class);
    }

    public function boot(): void
    {
    }
}
