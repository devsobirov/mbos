<?php


namespace App\Helpers;


use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Project;

class LogTypeHelper
{
    const TYPE_INFO = 1;
    const TYPE_WARNING = 2;
    const TYPE_SUCCESS = 3;
    const TYPE_DANGER = 4;

    const GROUP_PROJECT = Project::class;
    const GROUP_PLAN = Plan::class;
    const GROUP_CUSTOMER = Customer::class;
    const GROUP_INVOICE = Invoice::class;
    const GROUP_PAYMENT = Payment::class;

    const TYPE_LIST = [
        self::TYPE_SUCCESS => 'Создание или Успешное действие',
        self::TYPE_WARNING => 'Редактирование',
        self::TYPE_DANGER => 'Удаление или Неудачное дейстие',
        self::TYPE_INFO => 'Разное информириющие',
    ];

    const TYPE_COLORS = [
        self::TYPE_SUCCESS => 'bg-teal',
        self::TYPE_WARNING => 'bg-yellow',
        self::TYPE_DANGER => 'bg-pink',
        self::TYPE_INFO => 'bg-azure',
    ];

    const GROUP_LIST = [
        Invoice::class => 'Shartnomalar',
        Payment::class => 'To\'lovlar',
        Customer::class => 'Mijozlar',
        Project::class => 'Loyihalar',
        Plan::class => 'Tarf rejalar',
    ];

    public static function getTypes(): array
    {
        return self::TYPE_LIST;
    }

    public static function getGroups(): array
    {
        return self::GROUP_LIST;
    }

    public static function getBadgeClass($type): string
    {
        return array_key_exists($type, self::getTypes())
            ? self::TYPE_COLORS[$type]
            : '';
    }
}
