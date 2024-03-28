<?php


namespace App\Traits;


use App\Helpers\PaymentTypeHelper;

trait HasPaymentType
{
    public function getPaymentType(): string
    {
        return PaymentTypeHelper::getPaymentType($this->type);
    }
}
