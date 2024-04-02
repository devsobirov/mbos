@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none d-flex flex-row align-items-center justify-content-between">
            <h2 class="page-title">
                Barcha mijozlar
                @if ($paginated->total() > 0)
                    (Показаны записи с {{ $paginated->firstItem() }} по {{ $paginated->lastItem() }} из всего {{ $paginated->total() }}.)
                @endif
            </h2>
            <div class="col-auto ms-auto d-print-none">
                <form action="{{route('customers.index')}}" class="d-md-flex d-sm-block align-items-center">
                    <input type="search" class="form-control d-inline-block w-9 me-1" placeholder="Kod, ism, tel ..." name="search" value="{{request('search')}}">
                    <button class="btn me-1 btn-icon btn-azure" title="Izlash"><x-svg.search></x-svg.search></button>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#customer-form-" class="btn btn-primary">Создать новый</a>
                </form>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="table-responsive">
                    @include('admin.customers._table', ['paginated' => $paginated])
                </div>
                @if( $paginated->hasPages() )
                    <div class="card-footer pb-0">
                        {{ $paginated->links() }}
                    </div>
                @endif
            </div>
            @include('admin.customers._form', ['item' => new \App\Models\Customer()])
        </div>
    </div>
@endsection

<script>
    function invoiceFormData() {
        return {
            url: null,
            next() {
                this.isValid()
                    ? window.location = this.url
                    : alert('Davom qilish uchun loyihani tanlang!');
            },
            isValid() {
                return !!this.url;
            }
        }
    }
</script>
