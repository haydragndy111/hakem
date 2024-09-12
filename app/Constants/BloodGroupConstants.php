<?php

namespace App\Constants;

class BloodGroupConstants
{

    // Blood Types Types
    const A = 1;
    const B = 2;
    const O = 3;
    const APositive = 4;
    const BPositive = 5;
    const OPositive = 6;
    const ANegative = 7;
    const BNegative = 8;
    const ONegative = 9;

    public static function getBloodGroups()
    {
        return [
            self::A,
            self::B,
            self::O,
            self::APositive,
            self::BPositive,
            self::OPositive,
            self::ANegative,
            self::BNegative,
            self::ONegative,
        ];
    }

    public static function getBloodGroupsValues()
    {
        return [
            self::A => 'A',
            self::B => 'B',
            self::O => 'O',
            self::APositive => 'A-',
            self::BPositive => 'B-',
            self::OPositive => 'O-',
            self::ANegative => 'A+',
            self::BNegative => 'B+',
            self::ONegative => 'O+',
        ];
    }
}
