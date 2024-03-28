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
                    @include('admin.customers._create_invoice_form', ['item' => $item])
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="7" class="py-4 text-center">Клиенты не найдены, <a href="#" data-bs-toggle="modal" data-bs-target="#customer-form-">создайте нового</a></td></tr>
    @endforelse
    </tbody>
</table>
