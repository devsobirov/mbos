<style>
    @media (min-width: 992px) {
        .modal-lg, .modal-xl {
            --tblr-modal-width: 900px;
        }
    }
</style>

<table class="table" id="dataTable" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($paginated as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td class="w-25">{{ $item->name }}</td>
            <td>{{$item->phone ?: '-'}}</td>
            <td>{{$item->email ?: '-'}}</td>
            <td>{{$item->created_at->format('Y-m-d H:i')}}</td>
            <td>{{$item->updated_at->format('Y-m-d H:i')}}</td>
            <td>
                <div class="d-flex align-items-center" style="gap:4px">

                    <a href="#" class="btn btn-icon btn-azure" data-bs-target="#invoice-form-{{$item->id}}" data-bs-toggle="modal" title="Shartnoma yaratish"><x-svg.plus></x-svg.plus> </a>
                    <a href="#" class="btn btn-icon btn-success" data-bs-target="#customer-form-{{$item->id}}" data-bs-toggle="modal" >
                        <x-svg.pen></x-svg.pen>
                    </a>
                    @if($i = $item->invoices_count)
                        <a href="{{route('invoices.customer', $item->id)}}" class="btn btn-warning">Shartnomalar ({{$i}})</a>
                    @endif
                    @include('admin.customers._form', ['item' => $item])
                    @include('admin.invoices._form', ['item' => $item])
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="7" class="py-4 text-center">Клиенты не найдены, <a href="#" data-bs-toggle="modal" data-bs-target="#customer-form-">создайте нового</a></td></tr>
    @endforelse
    </tbody>
</table>
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
