<?php

namespace App\Http\Requests\Invoice;

use App\Models\Invoice;
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
        $planRules = [
            'plan.plan_id' => 'required|numeric|exists:plans,id',
            'plan.qty' => 'required|numeric|min:1',
            'plan.extra_price' => 'nullable|numeric|min:0',
            'plan.base_price' => 'required|numeric',
            'plan.cost' => 'required|numeric',
            'plan.start_date' => 'required',
            'plan.expire_date' => 'nullable',
        ];

        $serviceRules = [
            'services' => 'nullable|array',
//            'services.*' => 'required|numeric|exists:plans,id',
            'services.*.qty' => 'numeric|min:1',
            'services.*.cost' => 'numeric|min:1',
        ];

        $rules = [
            'project_id' => 'required|numeric|exists:projects,id',
            'customer_id' => 'required|numeric|exists:customers,id',
            'fixed_discount' => 'nullable|numeric|min:0',
            'percent_discount' => 'nullable|numeric|min:0|max:99',
            'percent_discount_sum' => 'nullable|numeric|min:0',
            'total_cost' => 'required|numeric',
            'next_payment_date' => 'required',
            'notes' => 'nullable|string',
            'status' => 'numeric'
        ];
        if ($this->plan_id) $rules = array_merge($rules, $planRules);
        if (!empty($this->services)) $rules = array_merge($rules, $serviceRules);

        return $rules;
    }

    protected function prepareForValidation()
    {
        $cost = 0;
        $serviceCost = 0;
        $plan = [];

        if ($this->plan_id) {

            $plan = Plan::withTrashed()->findOrFail($this->plan_id);

            $plan_id = $this->plan_id;
            $base_price = (int) ($plan->base_price * $this->base_qty);
            $extra_price = (int) ($plan->per_extra_price * $this->extra_qty * $this->base_qty);
            $cost = $base_price + $extra_price;
            $qty = $this->base_qty;
            $start_date = $this->start_date;
            $expire_date = $this->expire_date;
            $plan = compact('plan_id', 'qty', 'base_price', 'extra_price', 'cost', 'start_date', 'expire_date');
        }

        if (!empty($this->services)) {
            foreach ($this->services as $id => $data) {
                $serviceCost += $data['cost'];
            }
        }

        $total_cost = $serviceCost + $cost;

        $fixed_discount = (int)$this->base_discount;
        $percent_discount = (float) $this->percent_discount;
        $percent_discount_sum = $percent_discount ? (round($percent_discount * $total_cost * 0.01)) : 0;
        $total_discount = $fixed_discount + $percent_discount_sum;
        $total_cost = $total_cost - $total_discount;
        $status = Invoice::STATUS_ACTIVE;

        $this->merge(
            compact('total_cost', 'fixed_discount', 'percent_discount', 'percent_discount_sum', 'plan', 'status')
        );
    }
}
