@extends('admin.layouts.app')


@section('content')
    <div class="page-body">
        <div class="container-xl">

            <div class="page-header d-print-none mt-5">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Aktiv shartnomalar @if($total = $invoices->total())({{$total}})@endif</h2>
                    </div>

                    <div class="col-auto ms-auto d-print-none">
                        <a href="#" class="btn btn-primary">Some button</a>
                        <a href="#" class="btn btn-success">Another button</a>
                    </div>
                </div>
            </div>

            <div class="page-body">
                <div class="card">
                    <div class="table-responsive">
                        @include('admin.invoices._table-home', ['paginated' => $invoices])
                    </div>
                    @if( $invoices->hasPages() )
                        <div class="card-footer pb-0">
                            {{ $invoices->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
