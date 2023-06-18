<?php

namespace App\Services\CodeGenerator;

enum code_type: string
{
    case NUMERIC = 'numeric';
    case ALPHA = 'alpha';
    case ALPHANUMERIC = 'alphanumeric';
}
