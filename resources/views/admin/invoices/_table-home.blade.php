<table class="table" id="dataTable" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        <th>Mijoz</th>
        <th>Loyiha/Tarif</th>
        <th>Summa (sum)</th>
        <th>To'langan (sum)</th>
        <th>Qoldiq (sum)</th>
        <th>To'lov sanasi</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($paginated as $item)
        <tr>
            <td>#{{$item->number}} <br>ID: {{ $item->id }}</td>
            <td><a href="{{route('invoices.customer', $item->customer_id)}}">{{$item->customer->name}}</a></td>
            <td>{{ $item->project->name }}</td>
            <td>{{$item->total_cost}}</td>
            <td>{{$item->payments_sum_amount}}</td>
            <td>{{$item->total_cost - $item->calculateUnpaidAmount()}} </td>
            <td>{{$item->next_payment_date->format('d-M-Y')}}</td>
            <td>
                <div class="d-flex align-items-center" style="gap:4px">
                    <a href="{{route('invoices.show', $item->number)}}" class="btn btn-success">
                        Batafsil
                    </a>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="8" class="py-4 text-center">Aktive shartnomalar topilmadi</td></tr>
    @endforelse
    </tbody>
</table>
<script></script>
