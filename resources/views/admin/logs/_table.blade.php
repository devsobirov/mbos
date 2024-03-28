<table class="table" id="dataTable" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        <th>Author</th>
        <th>Event / Message</th>
        <th>Event time</th>
    </tr>
    </thead>
    <tbody>
    @forelse($paginated as $item)
        @php $color = \App\Helpers\LogTypeHelper::getBadgeClass($item->log_type);@endphp
        <tr>
            <td>{{ $item->id }}</td>
            <td><span class="badge {{$color}}">{{ $item->user ? $item->user->name : 'SYSTEM'}}</span></td>
            <td class="w-50">{{ $item->event }} <p>{!! $item->message !!}</p></td>
            <td><span class="badge  {{$color}}-lt">{{$item->created_at->format('Y-m-d H:i')}}</span></td>
        </tr>
    @empty
        <tr><td colspan="4" class="py-4 text-center">Logs not found</td></tr>
    @endforelse
    </tbody>
</table>
