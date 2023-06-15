<?php

namespace App\Services\CodeGenerator;

use Illuminate\Database\Eloquent\Collection;

interface CodeGeneratorService
{
    public static function generate(Collection $queryResult, string $prefix = '', int $startIndex = 0, int $length = 4);
}
