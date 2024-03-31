<div class="card-header">
    <h3 class="card-title">Shartnoma ma'lumotlari</h3>
</div>
<div class="card-table table-responsive">
    <table class="table table-vcenter">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nomi</th>
            <th>Miqdori</th>
            <th>Boshlanish muddati</th>
            <th>Tugash muddati</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        @forelse($subscriptions as $item)
        @endforeach
        <tr>
            <td>ID: {{ $item->id }}<br> #{{$item->number}}</td>
            <td>{{ $item->project->name }} / {{$item->plan->name}}</td>
            <td>
                Asosiy: {{$item->base_qty}} {{$item->plan->unit}}
                @if($item->extra_qty)
                    <br>Qo'shimcha: {{$item->extra_qty}} (xodim)
                @endif
            </td>
            <td>{{$item->start_date ? $item->start_date->format('d-M-Y') : ''}}</td>
            <td>@if($item->lifetime)
                    Muddatsiz
                @else
                    {{$item->expire_date ? $item->expire_date->format('d-M-Y') : ''}} <br>
                    {{$item->left_days}}
                @endif
            </td>
            <td>
                <span class="badge badge-success">Aktiv</span>
            </td>
            <td> Yaratilgan: {{$item->created_at->format('Y-m-d H:i')}} <br> Tahrirlangan: {{$item->created_at->format('Y-m-d H:i')}}</td>
        </tr>
    </table>
</div>
