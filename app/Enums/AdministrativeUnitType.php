<?php

namespace App\Enums;

enum AdministrativeUnitType: int
{
    case CITY = 1;
    case PROVINCE = 2;

    case COUNTY = 3;
    case DISTRICT = 4;

    case WARD = 5;
    case COMMUNE = 6;
    case TOWN = 7;

    public static function wards(): array
    {
        return [
            self::WARD->value,
            self::COMMUNE->value,
            self::TOWN->value,
        ];
    }

    public static function districts(): array
    {
        return [
            self::COUNTY->value,
            self::DISTRICT->value,
        ];
    }

    public static function provinces(): array
    {
        return [
            self::CITY->value,
            self::PROVINCE->value,
        ];
    }
}
