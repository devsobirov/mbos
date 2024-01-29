<?php


namespace App\Traits;


use App\Helpers\UnitHelper;

trait HasUnit
{
    public function getUnit(): string
    {
        return UnitHelper::getUnit($this->unit_id);
    }

    public function isExpirable(): bool
    {
        return UnitHelper::isExpirable($this->unit_id);
    }
}
