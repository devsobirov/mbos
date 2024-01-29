<table class="table" id="dataTable" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        <th width="90px"></th>
        <th>Name</th>
        <th>Created at</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($projects as $project)
        <tr>
            <td>{{ $project->id }}</td>
            <td><img src="{{$project->logoUrl()}}" style="display: block; width: 80px" alt=""></td>
            <td>{{ $project->name }}</td>
            <td>{{ $project->created_at ? $project->created_at->format('d-m-Y H:i') : '-'}}</td>
            <td>{{ $project->deleted_at ? "O'chirilgan " . $project->deleted_at->format('d-m-Y H:i') : 'Aktiv'}}</td>
            <td>
                <div class="d-flex align-items-center" style="gap:4px">
                    <a href="#" class="btn btn-icon btn-success" data-bs-target="#project-form-{{$project->id}}" data-bs-toggle="modal" >
                        <x-svg.pen></x-svg.pen>
                    </a>
                    @include('admin.projects._form', ['$project' => $project])
                    <a href="{{route('projects.plans', $project->id)}}" class="btn btn-icon btn-primary px-3" title="Тарифы">
                        Тарифы @if($count = $project->plans_count) ({{$count}}) @endif
                    </a>

                    @if(!$project->deleted_at)
                    <form action="{{route('projects.delete', $project->id)}}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-icon btn-danger" onclick="return confirm('Удалить?')">
                            <x-svg.trash></x-svg.trash>
                        </button>
                    </form>
                    @else
                    <form action="{{route('projects.delete', $project->id)}}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-icon btn-warning" onclick="return confirm('Вернуть?')">
                            <x-svg.return></x-svg.return>
                        </button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="py-4 text-center">Пооекты не найдены, <a href="#" data-bs-toggle="modal" data-bs-target="#project-form-">создайте нового</a></td></tr>
    @endforelse
    </tbody>
</table>
