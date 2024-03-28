@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <h2 class="page-title">
                Foydalanuvchilar
            </h2>
            <div class="col-auto ms-auto d-print-none">
                <a href="#" data-bs-toggle="modal" data-bs-target="#user-form-" class="btn btn-primary">Создать новый</a>
                @include('admin.users._form', ['item' => new \App\Models\User()])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email Address') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Created at') }}</th>
                                <th>{{ __('Updated in') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getRoleName() }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at->diffForhumans() }}</td>
                                <td>
                                    <a href="#" class="btn btn-icon btn-success" data-bs-target="#user-form-{{$user->id}}" data-bs-toggle="modal" >
                                        <x-svg.pen></x-svg.pen>
                                    </a>
                                    @include('admin.users._form', ['item' => $user])
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if( $users->hasPages() )
                <div class="card-footer pb-0">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
