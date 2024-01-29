@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none d-flex flex-row align-items-center justify-content-between">
            <h2 class="page-title">
                Тарифные планы проекта {{$project->name}}
                @if ($paginated->total() > 0)
                    (Показаны записи с {{ $paginated->firstItem() }} по {{ $paginated->lastItem() }} из {{ $paginated->total() }} всего.)
                @endif
            </h2>
            <div>
                <a href="{{route('projects.index')}}" class="btn btn-primary mx-1">Вернутся проектам</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#project-form-" class="btn btn-primary">Создать новый</a>
                @include('admin.plans._form', ['item' => new \App\Models\Plan()])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="table-responsive">
                    @include('admin.plans._table', ['paginated' => $paginated])
                </div>
                @if( $paginated->hasPages() )
                    <div class="card-footer pb-0">
                        {{ $paginated->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
