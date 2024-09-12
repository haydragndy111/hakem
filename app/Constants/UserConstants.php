<?php

namespace App\Constants;

class UserConstants
{

    const TYPE_ONE = 1;
    const TYPE_TWO = 2;

    const MALE = 1;
    const FEMALE = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const ROLE_SUPER_ADMIN = 1;
    const ROLE_ADMIN = 2;
    const ROLE_USER = 3;
    const ROLE_DOCTOR = 4;

    public static function getUserGenders()
    {
        return [
            self::MALE => 'male',
            self::FEMALE => 'female',
        ];
    }

    public static function getUserTypes()
    {
        return [
            self::TYPE_ONE => 'one',
            self::TYPE_TWO => 'two',
        ];
    }

    public static function getRolesConstants()
    {
        return [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_ADMIN,
            self::ROLE_USER,
            self::ROLE_DOCTOR,
        ];
    }

    public static function getRoles()
    {
        return [
            self::ROLE_SUPER_ADMIN => 'super admin',
            self::ROLE_ADMIN => 'admin',
            self::ROLE_DOCTOR => 'doctor',
            self::ROLE_USER => 'user',
        ];
    }

}
