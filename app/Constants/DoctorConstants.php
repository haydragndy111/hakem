<?php

namespace App\Constants;

class DoctorConstants
{

    const FEATURED = 1;
    const POPULAR = 2;

    const TYPE_ONE = 1;
    const TYPE_TWO = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const MALE = 1;
    const FEMALE = 2;

    public static function getDoctorStatus()
    {
        return [
            self::STATUS_ACTIVE => 'active',
            self::STATUS_INACTIVE => 'in-active',
        ];
    }

    public static function getUserGenders()
    {
        return [
            self::MALE => 'male',
            self::FEMALE => 'female',
        ];
    }

    public static function getDoctorTypes()
    {
        return [
            self::TYPE_ONE => 'one',
            self::TYPE_TWO => 'two',
        ];
    }
}
