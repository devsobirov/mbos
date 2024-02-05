<?php

namespace App\Http\Requests\Invoice;

use App\Models\Plan;
use Illuminate\Foundation\Http\FormRequest;

class SaveInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|numeric|exists:projects,id',
            'customer_id' => 'required|numeric|exists:customers,id',
            'plan_id' => 'required|numeric|exists:plans,id',
            'base_qty' => 'required|numeric|min:1',
            'extra_qty' => 'nullable|numeric|min:0',
            'base_discount' => 'nullable|numeric|min:0',
            'base_cost' => 'required|numeric',
            'extra_cost' => 'nullable|numeric',
            'total_cost' => 'required|numeric',
            'start_date' => 'required',
            'expire_date' => 'nullable',
            'next_payment_date' => 'required',
            'lifetime' => 'boolean',
            'notes' => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        $plan = Plan::withTrashed()->findOrFail($this->plan_id);

        $base_discount = (int)$this->base_discount;
        $base_cost = (int) ($plan->base_price * $this->base_qty);
        $extra_cost = (int) ($plan->per_extra_price * $this->extra_qty * $this->base_qty);
        $total_cost = $base_cost + $extra_cost - $base_discount;
        $lifetime = !$plan->isExpirable();

        $this->merge(compact('base_cost', 'extra_cost', 'total_cost', 'base_discount','lifetime'));
    }
}
