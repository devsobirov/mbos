<table class="table" id="dataTable" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        @isset($withCustomer)
            <th>Mijoz</th>
        @endisset
        <th>Loyiha/Tarif</th>
        <th>Narx</th>
        <th>To'langan</th>
        <th>Status</th>
        <th>Muddat</th>
        <th>Yaratilgan</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($paginated as $item)
        <tr>
            <td>
                #{{$item->number}}
                ID: {{ $item->id }}
            </td>
            @isset($withCustomer)
                <td>
                    <a href="{{route('invoices.customer', $item->customer_id)}}">{{$item->customer->name}}</a>
                </td>
            @endisset
            <td>{{ $item->project->name }} / {{$item->plan->name}}</td>
            <td>
                Jami: {{$item->total_cost}} <br>
                Asosiy: {{$item->base_cost}}
                @if($item->extra_cost)
                    <br>Qo'shimcha: {{$item->extra_cost}}
                @endif
                @if($item->base_discount)
                    <br>Chegirma: {{$item->base_discount}}
                @endif
            </td>
            <td>0 sum</td>
            <td>
                <span class="badge badge-success">Aktiv</span>
            </td>
            <td>
                Dan: {{$item->start_date ? $item->start_date->format('d-M-Y') : ''}} <br>
                @if($item->lifetime)
                    Muddatsiz
                @else
                    Gacha: {{$item->expire_date ? $item->expire_date->format('d-M-Y') : ''}} <br>
                    {{$item->left_days}}
                @endif
            </td>
            <td>{{$item->created_at->format('Y-m-d H:i')}}</td>
            <td>
                <div class="d-flex align-items-center" style="gap:4px">
                    <a href="{{route('invoices.show', $item->number)}}" class="btn btn-success" data-bs-target="#customer-form-{{$item->id}}" data-bs-toggle="modal" >
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
