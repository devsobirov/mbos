@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none d-flex flex-row align-items-center justify-content-between">
            <h2 class="page-title">
                Barcha loyihalar
                @if ($paginated->total() > 0)
                    (Ko'rsatilgan: {{ $paginated->firstItem() }} dan {{ $paginated->lastItem() }} gacha, jami {{ $paginated->total() }})
                @endif
            </h2>
            <a href="#" data-bs-toggle="modal" data-bs-target="#project-form-" class="btn btn-primary">Yangi yaratish</a>
            @include('admin.projects._form', ['project' => new \App\Models\Project()])
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="table-responsive">
                    @include('admin.projects._projects-table', ['projects' => $paginated])
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
