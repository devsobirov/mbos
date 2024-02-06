@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none d-flex flex-row align-items-center justify-content-between">
            <h2 class="page-title">
                Все проекты
                @if ($paginated->total() > 0)
                    (Показаны записи с {{ $paginated->firstItem() }} по {{ $paginated->lastItem() }} из всего {{ $paginated->total() }}.)
                @endif
            </h2>
            <div class="col-auto ms-auto d-print-none">
                <form action="{{route('customers.index')}}" class="d-md-flex d-sm-block align-items-center">
                    <input type="search" class="form-control d-inline-block w-9 me-1" placeholder="Kod, ism, tel ..." name="search" value="{{request('search')}}">
                    <button class="btn me-1 btn-icon btn-azure" title="Izlash"><x-svg.search></x-svg.search></button>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#customer-form-" class="btn btn-primary">Создать новый</a>
                </form>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="table-responsive">
                    @include('admin.customers._table', ['paginated' => $paginated])
                </div>
                @if( $paginated->hasPages() )
                    <div class="card-footer pb-0">
                        {{ $paginated->links() }}
                    </div>
                @endif
            </div>
            @include('admin.customers._form', ['item' => new \App\Models\Customer()])
        </div>
    </div>
@endsection

<script>
    let initialProjects = @json($projects);

    function defaultInvoice() {
        return {
            base_qty: 1,
            base_cost: null,
            base_discount: 0,
            extra_cost: 0,
            extra_discount: 0,
            extra_qty: 0,
            start_date: null,
            expire_date: null,
            notes: '',
            next_payment_date: '',
        }
    }
    function invoiceFormData() {
        return {
            projectList: [],
            plansList: [],
            currentPlan: false,
            project: null,
            plan: null,
            form: {project_id: null, plan_id: null},
            invoice: defaultInvoice(),
            init() {
                this.projectList = initialProjects;
            },
            setPlans() {
                let plans = []
                if (this.form.project_id) {
                    this.projectList.forEach(item => {
                        if (item.id === parseInt(this.form.project_id)) {
                            plans = item.plans
                        }
                    })
                }

                return this.plansList = plans;
            },
            setCurrentPlan() {
                this.invoice = defaultInvoice();
                if (this.plansList.length) {
                    this.plansList.forEach(item => {
                        if (item.id === parseInt(this.form.plan_id)) {
                            this.currentPlan = item;
                        }
                    })
                }
            },
            calcBaseCost() {
                if (this.currentPlan) {
                    return Math.floor(this.invoice.base_qty * this.currentPlan.price);
                }

                return 0;
            },
            calcExtraCost() {
                if (this.currentPlan && this.currentPlan.has_extra) {
                    return Math.floor(this.invoice.extra_qty * this.invoice.base_qty * this.currentPlan.per_extra_price);
                }

                return 0;
            },
            calcTotalCost() {
                return Math.floor(
                    this.calcBaseCost() + this.calcExtraCost() - this.invoice.base_discount - this.invoice.extra_discount
                );
            },
            setExpirationDate() {
                if (this.invoice.base_qty && this.invoice.start_date) {
                    // Parse the start date string to a Date object
                    const startDateObj = new Date(this.invoice.start_date);

                    // Add the base quantity (in months) to the start date
                    startDateObj.setMonth(startDateObj.getMonth() + parseInt(this.invoice.base_qty));

                    // Format the modified date as a string in the format "YYYY-MM-DD"
                    this.invoice.expire_date = startDateObj.toISOString().split('T')[0];
                    return true;
                }
                this.invoice.expire_date = null;
            },
            isValid() {
                return !!this.invoice.base_qty
                    && !!this.form.project_id
                    && !!this.form.plan_id
                    && (this.currentPlan && (!this.currentPlan.has_expiration || (this.invoice.start_date && this.invoice.expire_date)))
            }
        }
    }
</script>
