<?php

namespace App\Providers;

use App\Services\CodeGenerator\CodeGeneratorService;
use App\Services\CodeGenerator\CodeGeneratorServiceImplement;
use Illuminate\Support\ServiceProvider;

class CodeGeneratorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CodeGeneratorService::class,CodeGeneratorServiceImplement::class);
    }

    public function boot(): void
    {
    }
}
