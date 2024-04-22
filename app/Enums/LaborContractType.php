<?php

namespace App\Enums;

enum LaborContractType: int
{
    case FIXED_TERM = 1;
    case UNLIMITED = 2;
    case SEASONAL = 3;
}
