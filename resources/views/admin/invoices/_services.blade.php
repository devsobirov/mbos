<div class="card-table table-responsive">
    <table class="table table-vcenter">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nomi</th>
            <th>Miqdori</th>
            <th>Summa (UZS)</th>
            <th>Status</th>
            <th>Sana</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($services as $service)
            <tr>
                <td>{{$service->id }}<br></td>
                <td>{{$service->plan->name}}</td>
                <td>{{$service->qty}} {{$service->plan->getUnit()}}</td>
                <td>{{$service->cost}}</td>
                <td>
                    <span class="badge {{$service->statusClass()}}">{{$service->getStatusName()}}</span>
                </td>
                <td>
                    Yaratilgan: {{$service->created_at ? $service->created_at->format('Y-m-d H:i') : '-'}} <br>
                    Tahrirlangan: {{$service->updated_at ? $service->updated_at->format('Y-m-d H:i') : '-'}}</td>
                <td></td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">Shartnoma uchun kiritilgan xizlmatlar topilmadi</td></tr>
        @endforelse
        </tbody>

    </table>
</div>
