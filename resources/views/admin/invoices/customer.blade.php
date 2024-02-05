@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none d-flex flex-row align-items-center justify-content-between">
            <h2 class="page-title">
                {{$customer->name}} shartnomalari
                @if ($paginated->hasPages())
                    Ko'rsatilgan: ({{ $paginated->firstItem() }} dan {{ $paginated->lastItem() }} gacha, jami {{ $paginated->total() }})
                @endif
            </h2>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="table-responsive">
                    @include('admin.invoices._invoice-table', ['paginated' => $paginated])
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
