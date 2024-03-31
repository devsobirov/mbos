<?php


namespace App\Helpers;


class UnitHelper
{
    const QTY_PER_TIME = 1; // 1 time, 1 раз, 1 марта ...
    const QTY_PER_ITEM = 2; // 3 things, 3 dona, 3 шт
    const QTY_MONTH = 3; // 3 month, 3 месяца, 3 ой
    const QTY_DAY = 4; // 15 days, 15 дней, 15 кун

    /**
     * Gets units list with id=>name pair (basically for select element)
     *
     * @return string[]
     */
    public static function getUnits(): array
    {
        return [
            self::QTY_PER_TIME => 'марта',
            self::QTY_PER_ITEM => 'дона',
            self::QTY_MONTH => 'ой',
            self::QTY_DAY => 'кун',
        ];
    }

    /**
     * Gets units name (alias) by its id
     *
     * @param $unitId
     * @return string
     */
    public static function getUnit($unitId): string
    {
        if (array_key_exists($unitId, self::getUnits())) {
            return self::getUnits()[$unitId];
        }

        return '';
    }

    /**
     * Is unit has value related with expiration time for subject (service, plan)
     *
     * @param $unitId
     * @return bool
     */
    public static function isExpirable($unitId): bool
    {
        return in_array($unitId, [self::QTY_MONTH]);
    }
}
