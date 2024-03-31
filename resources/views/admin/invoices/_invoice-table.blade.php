<table class="table" id="dataTable" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        @isset($withCustomer)
            <th>Mijoz</th>
        @endisset
        <th>Loyiha/Tarif</th>
        <th>To'lovga tasdiqlangan</th>
        <th>To'langan</th>
        <th>Qoldiq</th>
        <th>Status</th>
        <th>Yaratilgan</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($paginated as $item)
        <tr>
            <td>
                #{{$item->number}} <br>
                ID: {{ $item->id }}
            </td>
            @isset($withCustomer)
                <td>
                    <a href="{{route('invoices.customer', $item->customer_id)}}">{{$item->customer->name}}</a>
                </td>
            @endisset
            <td>{{ $item->project->name }}</td>
            <td>{{number_format($item->total_cost, 0, ',', ' ')}} UZS<br></td>
            <td>{{number_format((int)$item->payments_sum_amount, 0, ',', ' ')}} UZS</td>
            <td>{{number_format($item->total_cost - $item->payments_sum_amount, 0, ',', ' ')}} UZS</td>
            <td>
                <span class="badge badge-success">Aktiv</span>
            </td>
            <td>{{$item->created_at->format('Y-m-d H:i')}}</td>
            <td>
                <div class="d-flex align-items-center" style="gap:4px">
                    <a href="{{route('invoices.show', $item->number)}}" class="btn btn-success">
                        Batafsil
                    </a>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="{{isset($withCustomer) ? 8 : 7}}" class="py-4 text-center">@empty($customer) Shartnomalar @else {{$customer->name}} ga tegishli shartnomalar @endempty topilmadi</td></tr>
    @endforelse
    </tbody>
</table>
<script></script>
