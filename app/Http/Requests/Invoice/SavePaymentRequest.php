<?php

namespace App\Http\Requests\Invoice;

use App\Helpers\PaymentTypeHelper;
use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class SavePaymentRequest extends FormRequest
{
    private ?Invoice $invoice = null;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|max:'.$this->getMaxPaymentAmount(),
            'number' => 'required|unique:payments,number',
            'left_amount' => 'required|numeric|min:0',
            'type' => 'required|numeric|in:'.implode(',',array_keys(PaymentTypeHelper::getTypeList())),
            'payment_for_date' => 'required|date',
            'next_payment_date' => ($this->hasLeftAmount() ? 'required' : 'nullable') .'|date',
            'invoice_id' => 'required|numeric|exists:invoices,id',
            'customer_id' => 'required|numeric|exists:customers,id',
            'user_id' => 'required|numeric|exists:users,id',
            'reason' => 'required|string|max:255',
        ];
    }

    public function validated()
    {
        // Remove 'next_payment_date' from the validated data
        return collect(parent::validated())->except('next_payment_date')->toArray();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id(),
            'invoice_id' => $this->getInvoice()->id,
            'customer_id' => $this->getInvoice()->customer_id,
            'left_amount' => $this->getInvoice()->calculateUnpaidAmount() - $this->amount,
            'number' => strtoupper(Str::random(8))
        ]);
    }

    private function hasLeftAmount(): bool
    {
        return $this->amount < $this->getInvoice()->calculateUnpaidAmount();
    }

    private function getMaxPaymentAmount(): int
    {
        return $this->getInvoice()->calculateUnpaidAmount();
    }

    private function getInvoice(): Invoice
    {
        if (!$this->invoice) {
            $this->invoice = $this->route('invoice');
        }
        return $this->invoice;
    }
}
