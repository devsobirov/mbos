<?php


namespace App\Helpers;


class PaymentTypeHelper
{
    const TYPE_CASH = 1;
    const TYPE_CARD  = 2;
    const TYPE_TRANSACTION = 3;

    public static function getTypeList(): array
    {
        return [
            self::TYPE_CASH => 'Naqd',
            self::TYPE_CARD => 'Plastik',
            self::TYPE_TRANSACTION => 'Pul o\'tkazish',
        ];
    }

    public static function getPaymentType(?int $type): string
    {
        if (array_key_exists($type, self::getTypeList())) {
            return self::getTypeList()[$type];
        }

        return '';
    }
}
