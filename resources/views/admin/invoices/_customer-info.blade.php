<div class="card-table table-responsive">
    <table class="table table-vcenter">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Created at</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $item->id }}</td>
            <td class="w-25">{{ $item->name }}</td>
            <td>{{$item->phone ?: '-'}}</td>
            <td>{{$item->email ?: '-'}}</td>
            <td>{{$item->created_at->format('Y-m-d H:i')}}</td>
        </tr>
        </tbody>
    </table>
</div>
