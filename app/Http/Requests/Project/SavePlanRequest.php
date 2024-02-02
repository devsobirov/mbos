<?php

namespace App\Http\Requests\Project;

use App\Helpers\UnitHelper;
use Illuminate\Foundation\Http\FormRequest;

class SavePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            "project_id" => 'required|numeric|exists:projects,id',
            "unit_id" => 'required|numeric|in:'. implode(',', array_keys(UnitHelper::getUnits())),
            "name" => 'required|max:255|unique:plans,name,'.$this->plan_id,
            "description" => 'nullable|max:1000',
            "base_amount" => 'required|numeric|min:0',
            "base_price" => 'required|numeric|min:0',
            "per_extra_amount" => 'nullable|numeric|min:0',
            "per_extra_price" => 'nullable|numeric|min:0',
            "status" => 'boolean',
            'is_expirable' => 'boolean'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_expirable' => UnitHelper::isExpirable($this->unit_id),
            'status' => (bool) $this->status
        ]);
    }
}
