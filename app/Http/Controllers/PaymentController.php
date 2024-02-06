<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\SavePaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        dd(Payment::get());
    }

    public function save(SavePaymentRequest $request, Invoice $invoice)
    {
        $payment = Payment::create($request->validated());
        $invoice->update(['next_payment_date' => $request->next_payment_date]);

        return redirect()->back()->with('success', 'Muvaffaqiyatli saqlandi');
    }
}
