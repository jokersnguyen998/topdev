<?php

namespace App\Enums;

enum SalaryType: int
{
    case HOURLY = 1;
    case DAILY = 2;
    case MONTHLY = 3;
    case YEARLY = 4;
}
