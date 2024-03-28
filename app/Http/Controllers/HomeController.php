<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $invoices = Invoice::whereNotNull('next_payment_date')
            ->with('project:id,name', 'plan:id,name', 'customer:id,name')
            ->withSum('payments', 'amount')
            ->orderBy('next_payment_date', 'asc')
            ->paginate(20);

        return view('admin.home', compact('invoices'));
    }
}
