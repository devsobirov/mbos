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
                <a href="#" class="btn btn-azure" data-bs-target="#payment-form" data-bs-toggle="modal" title="To'lov kirirish"><x-svg.plus></x-svg.plus> To'lov kirirish</a>
                @include('admin.payments._form', ['item' => $invoice])
            </div>
            <div class="card mb-4">
                <div class="table-responsive">
                    @include('admin.invoices._payment-info', ['items' => $payments])
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom_scripts')
    <script>
        const availableToPayment = parseInt("{{$invoice->calculateUnpaidAmount()}}");
        function paymentFormData() {
            return {
                payment_for_date: null,
                next_payment_date: null,
                amount: null,
                amount_left: 0,
                max_amount: null,
                type: null,
                init() {
                    this.max_amount = availableToPayment;
                    this.amount_left = availableToPayment;
                    this.payment_for_date = "{{$invoice->next_payment_date ? $invoice->next_payment_date->format('Y-m-d') : ''}}";
                },
                isValid() {
                    return !!this.type && !!this.amount && !!this.next_payment_date &&this.payment_for_date;
                },
                setLeftAmount(){
                    this.amount_left = this.amount
                        ? Math.floor(parseInt(this.max_amount) -  parseInt(this.amount))
                        : availableToPayment;
                },
                validateAmount() {
                    if (this.amount && (parseInt(this.amount) < 1000 || parseInt(this.amount) > this.max_amount)) {
                        alert(`To'lov summasi 1000 sumdan ${availableToPayment} sum orasida bo'lishi kereak!`);
                        this.amount = 1000;
                        this.setLeftAmount();
                        return false;
                    }
                }
            }
        }
    </script>
@endsection
