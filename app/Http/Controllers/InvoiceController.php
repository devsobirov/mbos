<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\Invoice\SaveInvoiceRequest;

class InvoiceController extends Controller
{
    public function index()
    {
        $paginated = Invoice::with('project:id,name', 'plan:id,name', 'customer:id,name')
            ->orderBy('status', 'asc')
            ->paginate(20);

        return view('admin.invoices.index', compact('paginated'));
    }

    public function customer(Customer $customer)
    {
        $paginated = Invoice::where('customer_id', $customer->id)
            ->with('project:id,name', 'plan:id,name')
            ->orderBy('status', 'asc')
            ->paginate(20);

        return view('admin.invoices.customer', compact('paginated', 'customer'));
    }

    public function show(Invoice $invoice)
    {
        $payments = Payment::where('invoice_id', $invoice->id)->orderBy('id', 'desc')->get();
        $lastPayment = $payments->first();

        return view('admin.invoices.invoice', compact('invoice', 'payments', 'lastPayment'));
    }

    public function create(SaveInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->validated());
        return redirect()->route('invoices.show', $invoice->number)
            ->with('success', "Muvaffaqiyatli saqlandi");
    }
}
