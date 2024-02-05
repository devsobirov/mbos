@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none d-flex flex-row align-items-center justify-content-between">
            <h2 class="page-title">
                Shartnoma #{{$invoice->number}}
            </h2>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <div class="card mb-4">
                <div class="table-responsive">
                    @include('admin.invoices._customer-info', ['item' => $invoice->customer])
                </div>
            </div>

            <div class="card mb-4">
                <div class="table-responsive">
                    @include('admin.invoices._invoice-info', ['item' => $invoice])
                </div>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <h3 class="card-title">To'lov ma'lumotlari</h3>
                <a href="#" class="btn btn-azure" data-bs-target="#invoice-form-" data-bs-toggle="modal" title="To'lov kirirish"><x-svg.plus></x-svg.plus> To'lov kirirish</a>
            </div>
            <div class="card mb-4">
                <div class="table-responsive">
                    @include('admin.invoices._payment-info', ['items' => $payments])
                </div>
            </div>
        </div>
    </div>
@endsection
