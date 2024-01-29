<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $paginated = Customer::search(request('search'))->paginate(15);
        return view('admin.customers.index', compact('paginated'));
    }

    public function save(Request $request)
    {
        $customer  = Customer::getOrNew($request->customer_id);
        $customer->fill($this->getValidatedSaveData($request))->save();

        return redirect()->route('customers.index')
            ->with('success', "Muvaffaqiytali saqlandi");
    }

    protected function getValidatedSaveData($request): array
    {
        return $request->validate([
            'name' => 'required|max:255',
            'phone' => 'nullable|max:255',
            'email' => 'nullable|max:255',
            'address' => 'nullable|max:255',
        ]);
    }
}
