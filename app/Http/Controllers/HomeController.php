<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $invoices = Invoice::whereNotNull('next_payment_date')
            ->where('status', Invoice::STATUS_ACTIVE)
            ->with('project:id,name', 'customer:id,name')
            ->withSum('payments', 'amount')
            ->orderBy('next_payment_date', 'asc')
            ->paginate(20);

        $subscriptions = Subscription::where('status', Plan::STATUS_ACTIVE)
            ->orderBy('expire_date', 'desc')
            ->paginate(10);

        return view('admin.home', compact('invoices', 'subscriptions'));
    }
}
