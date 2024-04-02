<div class="card-table table-responsive">
    <table class="table table-vcenter">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tashkilot / Manzil</th>
            <th>Tel</th>
            <th>Inn</th>
            <th>Yaratilgan</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $item->id }}</td>
            <td class="w-25">{{ $item->name }}</td>
            <td class="w-25">{{$item->phone ?: '-'}}</td>
            <td class="w-25">{{$item->inn ?: '-'}}</td>
            <td>{{$item->created_at->format('Y-m-d H:i')}}</td>
        </tr>
        </tbody>
        <thead>
        <tr>
            <th>ID</th>
            <th>Raxbar</th>
            <th>Manzil</th>
            <th>Izoh</th>
            <th>Tug'ilgan kun</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $item->id }}</td>
            <td class="w-25">{{ $item->fio ?: '-' }}</td>
            <td class="w-25">{!! $item->address ?: '-' !!}</td>
            <td class="w-25">{!! $item->notes ?: '-' !!}</td>
            <td>{{$item->birthday ? $item->birthday->format('Y-M-d') : '-'}}</td>
        </tr>
        </tbody>
    </table>
</div>
