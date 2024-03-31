<div class="modal modal-blur fade" id="subs-form-add-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document"
         x-data="continuePlanData('{{$item->start_date->format('Y-m-d')}}', '{{$item->expire_date->format('Y-m-d')}}', parseInt('{{round($item->cost/$item->qty)}}'))"
         x-init="initialQty = parseInt('{{$item->qty}}');"
    >
        <form action="{{route('invoice-item.continue-subs', $item->id)}}" class="modal-content" method="POST">
            @csrf
            <input type="hidden" name="customer_id" value="{{$item->id}}">
            <div class="modal-header">
                <h5 class="modal-title">{{$item->plan->name}} tarifini uzaytirish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2"><span class="pe-3">Boshlanish muddati:</span> {{$item->start_date ? $item->start_date->format('d-M-Y') : ''}}</div>
                <div class="mb-2"><span class="pe-3">Tugash muddati:</span>
                    {{$item->expire_date ? $item->expire_date->format('d-M-Y') : ''}} ({{$item->left_days}})
                </div>
                <div class="mb-2"><span class="pe-3">Holati: </span> <span class="badge {{$item->getStatusClass()}}">{{$item->getStatusName()}}</span></div>
                <div class="mb-2"><span class="pe-3">Summa: </span> {{$item->cost}} UZS</div>
                <div class="mb-4"></div>
                @if($item->status == \App\Models\Plan::STATUS_ACTIVE)
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <label class="form-label"><span>Oy sonini kiriting</span> <sup class="fw-bold text-danger">*</sup></label>
                            <input type="number" class="form-control" name="base_qty" required x-model="base_qty" min="1" @change="setExpirationDate">
                        </div>
                        <div class="col-md-8 col-sm-12 mb-3">
                            <label class="form-label">Asosiy xizmat narxi <sup class="fw-bold text-danger">*</sup></label>
                            <input type="text" class="form-control" readonly
                                   :value="`Xar 1 oy uchun ${monthlySum} UZS dan ${base_qty} oy uchun ${Math.floor(base_qty * monthlySum)} UZS`">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label">Tarif plan kuchga kirish sanasi<sup class="fw-bold text-danger">*</sup></label>
                            <input type="date" class="form-control" name="start_date" x-model="start_date" readonly>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label">Tarif plan tugash sanasi<sup class="fw-bold text-danger">*</sup></label>
                            <input type="date" class="form-control" name="expire_date" readonly x-model="expire_date">
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" @click="status = ''" data-bs-dismiss="modal">
                    Yopish
                </a>
                <button x-show="isValid()" class="btn btn-primary ms-auto">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                    Saqlash
                </button>
            </div>
        </form>
    </div>
</div>
