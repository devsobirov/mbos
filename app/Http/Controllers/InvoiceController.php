<?php

namespace App\Http\Controllers;

use App\Http\Resources\Invoice\PlanResource;
use App\Http\Resources\Invoice\ProjectResource;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Project;
use App\Http\Requests\Invoice\SaveInvoiceRequest;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $paginated = Invoice::with('project:id,name', 'customer:id,name')
            ->withSum('payments', 'amount')
            ->orderBy('status', 'asc')
            ->paginate(20);

        return view('admin.invoices.index', compact('paginated'));
    }

    public function customer(Customer $customer)
    {
        $paginated = Invoice::where('customer_id', $customer->id)
            ->with('project:id,name', 'plan:id,name')
            ->withSum('payments', 'amount')
            ->orderBy('status', 'asc')
            ->paginate(20);

        return view('admin.invoices.customer', compact('paginated', 'customer'));
    }

    public function show(Invoice $invoice)
    {
        $payments = Payment::where('invoice_id', $invoice->id)->orderBy('id', 'desc')->get();
        $lastPayment = $invoice->lastPayment;

        $services = $invoice->services;
        $subscriptions = $invoice->subscriptions;
        $serviceList = PlanResource::collection($invoice->project->plans->where('is_expirable', false));;
        $plans = PlanResource::collection($invoice->project->plans->where('is_expirable', true));
        return view('admin.invoices.invoice',
            compact('invoice', 'payments', 'lastPayment', 'services', 'subscriptions', 'plans', 'serviceList')
        );
    }

    public function create(Customer $customer, Project $project)
    {
        $item = $customer;
        $projects = ProjectResource::collection(Project::whereHas('plans')->with('plans')->get());
        $services = PlanResource::collection($project->plans->where('is_expirable', false));
        $subscriptions = PlanResource::collection($project->plans->where('is_expirable', true));

        return view(
            'admin.invoices.create',
            compact('projects', 'project', 'customer', 'item', 'services', 'subscriptions')
        );
    }

    public function save(SaveInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->only(
            "project_id",
            "customer_id",
            "fixed_discount",
            "percent_discount",
            "percent_discount_sum",
            "total_cost",
            "next_payment_date",
            "notes",
        ));

        if (!empty($request->plan)) {
            $subscription = $request->plan;
            $subscription['invoice_id'] = $invoice->id;
            Subscription::create($subscription);
        }

        if (!empty($request->services)) {
            foreach ($request->services as $id => $data) {
                $data['plan_id'] = $id;
                $data['invoice_id'] = $invoice->id;
                Service::create($data);
            }
        }

        return redirect()->route('invoices.show', $invoice->number)
            ->with('success', "Muvaffaqiyatli saqlandi");
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($request->status == Invoice::STATUS_ACTIVE) {
            $invoice->update([
                'next_payment_date' => $request->next_payment_date,
                'notes' => $request->notes
            ]);

            $invoice->save();
        } else {
            $this->archiveInvoice($invoice);
        }

        return redirect()->back()->with('success', 'Muvaffaqiyatli saqlandi');
    }

    protected function archiveInvoice(Invoice $invoice): void
    {
        $status = \request()->status;
        $planStatus = $status == Invoice::STATUS_CLOSED ? Plan::STATUS_CLOSED : Plan::STATUS_CANCELLED;
        $planCancelledAt = $planStatus === Plan::STATUS_CANCELLED ? now() : null;

        $invoice->update([
            'status' => $status,
            'next_payment_date' => null
        ]);

        Subscription::where('invoice_id', $invoice->id)->whereNotIn('status', [Plan::STATUS_CANCELLED, Plan::STATUS_CLOSED])
            ->update([
                'status' => $planStatus,
                'cancelled_at' => $planCancelledAt
            ]);

        Service::where('invoice_id', $invoice->id)->whereNotIn('status', [Plan::STATUS_CANCELLED, Plan::STATUS_CLOSED])
            ->update([
                'status' => $planStatus,
                'cancelled_at' => $planCancelledAt
            ]);
    }
}
