<table class="table" id="dataTable" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nomi/Ma'lumot</th>
        <th>Turi</th>
        <th>Bazis narx/miqdor</th>
        <th>Qo'shimcha narx/miqdor</th>
        <th>Status</th>
        <th>Yaratilgan</th>
        <th>Tahrirlangan</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($paginated as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td class="w-25">{{ $item->name }} <p class="fs-6 text-secondary">{{$item->description}}</p></td>
            <td>{{$item->is_expirable ? 'Tarif reja (obuna)' : 'Xizmat'}}</td>
            <td>{{$item->base_price}} sum/{{$item->base_amount}} {{$item->getUnit()}} uchun</td>
            <td>
                @if($item->per_extra_price && $item->per_extra_amount)
                    {{$item->per_extra_price}} UZS / xar {{$item->per_extra_amount}} {{$item->getUnit()}} uchun
                @else
                -
                @endif
            </td>
            <td>{!!$item->deleted_at ? "O'chirilgan: <br> " . $item->deleted_at->format('d-m-Y H:i') : 'Aktiv'!!}</td>
            <td>{{$item->created_at->format('Y-m-d H:i')}}</td>
            <td>{{$item->updated_at->format('Y-m-d H:i')}}</td>
            <td>
                <div class="d-flex align-items-center" style="gap:4px">
                    <a href="#" class="btn btn-icon btn-success" data-bs-target="#project-form-{{$item->id}}" data-bs-toggle="modal" >
                        <x-svg.pen></x-svg.pen>
                    </a>
                    @include('admin.plans._form', ['item' => $item])
                    @if(!$item->deleted_at)
                        <form action="{{route('projects.delete-plan', $item->id)}}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-icon btn-danger" onclick="return confirm('Удалить?')">
                                <x-svg.trash></x-svg.trash>
                            </button>
                        </form>
                    @else
                        <form action="{{route('projects.delete-plan', $item->id)}}" method="POST">
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
        <tr><td colspan="9" class="py-4 text-center">Tarif va xizmatlar topilmadi, <a href="#" data-bs-toggle="modal" data-bs-target="#project-form-">yangi tarif yarating</a></td></tr>
    @endforelse
    </tbody>
</table>
