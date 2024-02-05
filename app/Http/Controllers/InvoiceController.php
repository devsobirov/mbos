<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\Invoice\SaveInvoiceRequest;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        dd($invoice);
    }

    public function create(SaveInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->validated());
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', "Muvaffaqiyatli saqlandi");
    }
}
