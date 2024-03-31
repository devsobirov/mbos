<?php

namespace App\Http\Controllers;

use App\Http\Resources\Invoice\PlanResource;
use App\Http\Resources\Invoice\ProjectResource;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Project;
use App\Http\Requests\Invoice\SaveInvoiceRequest;
use App\Models\Service;
use App\Models\Subscription;

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
        $plans = PlanResource::collection($invoice->project->plans->where('is_expirable', true));
        return view('admin.invoices.invoice',
            compact('invoice', 'payments', 'lastPayment', 'services', 'subscriptions', 'plans')
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
}
