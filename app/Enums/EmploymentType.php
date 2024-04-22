<?php

namespace App\Enums;

enum EmploymentType: int
{
    case FULL_TIME = 1;
    case PART_TIME = 2;
    case TEMPORARY = 3;
    case FREELANCE = 4;
}
