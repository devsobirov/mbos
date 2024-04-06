<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function updateSubs(Request $request, Subscription $subscription)
    {
        if ($subscription->status == Plan::STATUS_ACTIVE) {
            if ($request->status == Plan::STATUS_CANCELLED) {
                $this->cancelInvoiceItem($subscription->invoice, $subscription);
            } elseif ($request->status == Plan::STATUS_DEACTIVE) {
                $this->deactivateSubs($subscription);
            } else {
                $subscription->update(['status' => $request->status]);
            }

        }
        return redirect()->back()->with('success', 'Muvaffaqiyatli saqlandi');
    }

    public function addSubs(Request $request, Invoice $invoice)
    {
        $request->validate([
            'plan_id' => 'required|numeric|exists:plans,id',
            'base_qty' => 'required|numeric|min:1',
            'extra_qty' => 'nullable|numeric',
            'start_date' => 'required',
            'expire_date' => 'required',
            "fixed_discount" => 'nullable|numeric|min:0',
            "next_payment_date" => 'required',
        ]);

        $planData = $request->only('plan_id', 'start_date', 'expire_date', 'extra_qty');
        $plan = Plan::withTrashed()->findOrFail($request->plan_id);
        $qty = $request->base_qty;
        $extra_qty = $request->extra_qty;
        $base_price = (int) ($plan->base_price * $qty);
        $extra_price = (int) ($plan->per_extra_price * $qty * $extra_qty);
        $planData['qty'] = $qty;
        $planData['cost'] = $base_price + $extra_price;
        $planData['base_price'] = $base_price;
        $planData['extra_price'] = $extra_price;
        $planData['invoice_id'] = $invoice->id;

        if ($subscription = Subscription::create($planData)) {
            $total = $invoice->total_cost;
            $invoice->total_cost = $total + ($subscription->cost - (int) $request->fixed_discount);
            $invoice->next_payment_date = $request->next_payment_date;
            $invoice->total_discount += (int) $request->fixed_discount;
            $invoice->save();
        }

        return redirect()->back()->with('success', 'Muvaffaqiyatli saqlandi');
    }

    protected function deactivateSubs(Subscription $subscription)
    {
        $subscription->status = Plan::STATUS_DEACTIVE;
        $subscription->deactivated_at = now();
        $subscription->deactivated_by = auth()->id();

        $subscription->save();
    }

    public function continueSubs(Request $request, Subscription $subscription)
    {
        $request->validate([
            'base_qty' => 'required|numeric|min:1',
            'expire_date' => 'required|date_format:Y-m-d',
            'amount' => 'required|numeric',
            'type' => 'required|numeric',
            'payment_for_date' => 'required|date_format:Y-m-d',
            'created_at' => 'required|date_format:Y-m-d',
            'reason' => 'required',
        ]);

        $qty = $subscription->qty;
        $cost = $subscription->cost;
        $perCost = $cost/$qty;
        $newCost = round($request->amount);

        $subscription->update([
            'qty' => $qty + $request->base_qty,
            'cost' => $cost + $newCost,
            'expire_date' => $request->expire_date
        ]);

        if (!$subscription->isExpired()) {
            $subscription->update(['status' => Plan::STATUS_ACTIVE]);
        }
        Payment::create([
            'amount' => $request->amount,
            'type' => $request->type,
            'payment_for_date' => $request->payment_for_date,
            'created_at' => $request->created_at,
            'reason' => $request->reason,
            'number' => strtoupper(Str::random(8)),
            'left_amount' => 0,
            'invoice_id' => $subscription->invoice_id,
            'customer_id' => $subscription->invoice->customer_id,
            'subscription_id' => $subscription->id,
            'user_id' => auth()->id(),
        ]);

        $invoice = $subscription->invoice;
        $total = $invoice->total_cost;

        $invoice->update(['total_cost' => $total + $newCost]);
        return redirect()->back()->with('success', 'Muvaffaqiyatli saqlandi');
    }

    public function addService(Request $request, Invoice $invoice)
    {
        $request->validate([
            'services' => 'nullable|array',
            'services.*.qty' => 'numeric|min:1',
            'services.*.cost' => 'numeric|min:1',
            'base_discount' => 'nullable|numeric'
        ]);

        $cost = 0;

        if (!empty($request->services)) {
            foreach ($request->services as $id => $data) {
                $cost += $data['cost'];

                $data['plan_id'] = $id;
                $data['invoice_id'] = $invoice->id;
                Service::create($data);
            }
        }

        $total = $invoice->total_cost;
        $invoice->total_cost = $total + ($cost - (int) $request->base_discount);
        $invoice->next_payment_date = $request->next_payment_date;
        $invoice->total_discount += (int) $request->base_discount;
        $invoice->save();

        return redirect()->back()->with('success', 'Muvaffaqiyatli saqlandi');
    }

    public function updateService(Request $request, Service $service)
    {
        if ($service->status == Plan::STATUS_ACTIVE) {
            if ($request->status == Plan::STATUS_CANCELLED) {
                $this->cancelInvoiceItem($service->invoice, $service);
            } else {
                $service->update(['status' => $request->status]);
            }

        }
        return redirect()->back()->with('success', 'Muvaffaqiyatli saqlandi');
    }

    public function cancelInvoiceItem(Invoice $invoice, Model $model): void
    {
        $data = [];
        $paid = \request()->cancelled_with_paid_sum < $model->cost ? \request()->cancelled_with_paid_sum : $model->cost;
        $unpaid = $model->cost - $paid;

        $data['status'] = Plan::STATUS_CANCELLED;
        $data['cancelled_at'] = now();
        $data['cancelled_with_paid_sum'] = $paid;

        if ($model->update($data)) {
            $total = $invoice->total_cost;
            $cancelled = $invoice->total_cancelled;
            $unpaid = ($unpaid < $total) ? $unpaid : $total;
            $cancelled += $unpaid;

            $invoice->update([
                'total_cost' => $total - $unpaid,
                'total_cancelled' => $cancelled
            ]);
        }
    }
}
