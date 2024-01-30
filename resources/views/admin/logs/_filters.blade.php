<div class="col-auto ms-auto d-print-none">
    <form action="{{route('logs.index')}}" class="d-flex align-items-end gap-2">
        <select class="form-select" name="type">
            <option value="">Barcha tiplar</option>
            @foreach(\App\Helpers\LogTypeHelper::getTypes() as $id => $name)
                <option value="{{$id}}" @if(request('type') == $id) selected @endif>{{$name}}</option>
            @endforeach
        </select>
        <select class="form-select" name="group">
            <option value="">Barcha guruhlar</option>
            @foreach(\App\Helpers\LogTypeHelper::getGroups() as $id => $name)
                <option value="{{$id}}" @if(request('group') == $id) selected @endif>{{$name}}</option>
            @endforeach
        </select>
        <select class="form-select" name="user_id">
            <option value="">Barcha foydalnuvchilar</option>
            @foreach(\App\Models\User::select('id', 'name')->get() as $user)
                <option value="{{$user->id}}" @if(request('user_id') == $user->id) selected @endif>{{$user->name}}</option>
            @endforeach
        </select>
        <div class="">
            <label class="form-label">Sanadan</label>
            <input type="date" name="fromDate" value="{{request('fromDate')}}" class="form-control">
        </div>

        <div class="">
            <label class="form-label">Sanagacha</label>
            <input type="date" name="toDate" value="{{request('toDate')}}" class="form-control">
        </div>
        <button class="btn btn-primary">Izlash</button>
    </form>
</div>
