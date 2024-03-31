<div class="card-table table-responsive">
    <table class="table table-vcenter">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nomi</th>
            <th>Bazaviy miqdor/summa</th>
            <th>Qo'shimcha miqdor/summa</th>
            <th>Jami summa UZS</th>
            <th>Boshlanish muddati</th>
            <th>Tugash muddati</th>
            <th>Status</th>
            <th>Sana</th>
            <th></th>
        </tr>
        </thead>
        @forelse($subscriptions as $item)
            <tr>
                <td>ID: {{ $item->id }}</td>
                <td>{{$item->plan->name}}</td>
                <td>{{$item->qty}} {{$item->plan->unit}} / {{$item->base_price}} UZS</td>
                <td>{{$item->extra_qty}} xodim / {{$item->extra_price}} UZS</td>
                <td>{{$item->cost}} UZS</td>
                <td>{{$item->start_date ? $item->start_date->format('d-M-Y') : ''}}</td>
                <td>
                    {{$item->expire_date ? $item->expire_date->format('d-M-Y') : ''}} <br>
                    {{$item->left_days}}
                </td>
                <td>
                    <span class="badge {{$item->getStatusClass()}}">{{$item->getStatusName()}}</span>
                </td>
                <td>
                    <a href="#" data-bs-target="#subs-form-{{$item->id}}" data-bs-toggle="modal" class="btn btn-icon btn-warning" title="Boshqarish">
                        <x-svg.settings-sm></x-svg.settings-sm>
                    </a>
                    @include('admin.subscriptions._subs-form', ['item' => $item])
                </td>
            </tr>
        @empty
            <tr><td colspan="10" class="text-center">Obuna tariflari topilmadi</td></tr>
        @endforelse
    </table>
</div>
