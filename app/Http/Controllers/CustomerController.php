<?php

namespace App\Http\Controllers;

use App\Http\Resources\Invoice\ProjectResource;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $paginated = Customer::search(request('search'))->withCount('invoices')->paginate(15);
        $projects = ProjectResource::collection(Project::whereHas('plans')->with('plans')->get());

        return view('admin.customers.index', compact('paginated', 'projects'));
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
            'fio' => 'nullable|max:255',
            'notes' => 'nullable|max:2000',
            'birthday' => 'nullable',
            'inn' => 'nullable'
        ]);
    }
}
