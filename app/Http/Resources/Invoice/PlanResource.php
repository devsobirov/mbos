<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'amount' => $this->base_amount,
            'price' => $this->base_price,
            'has_extra' => !!$this->per_extra_amount && !!$this->per_extra_price,
            'per_extra_amount' => $this->per_extra_amount,
            'per_extra_price' => $this->per_extra_price,
            'unit' => $this->getUnit(),
            'has_expiration' => $this->is_expirable
        ];
    }
}
