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

                    <a href="#" class="btn btn-azure" data-bs-target="#invoice-form-{{$item->id}}" data-bs-toggle="modal">Invoices @if($i = $item->invoices_count)({{$i}})@endif</a>
                    <a href="#" class="btn btn-icon btn-success" data-bs-target="#customer-form-{{$item->id}}" data-bs-toggle="modal" >
                        <x-svg.pen></x-svg.pen>
                    </a>
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

    function invoiceFormData() {
        return {
            projectList: [],
            project: null,
            plan: null,
            form: {project_id: null, plan_id: null},
            init() {
                this.projectList = initialProjects;
            },
            getPlans() {
                let plans = []
                if (this.form.project_id) {
                    this.projectList.forEach(item => {
                        if (item.id === parseInt(this.form.project_id)) {
                            plans = item.plans
                        }
                    })
                }

              return plans;
            },
        }
    }
</script>
