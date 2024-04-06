<div class="modal modal-blur fade" id="subs-form-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('invoice-item.update-subs', $item->id)}}" class="modal-content" method="POST"
              x-data="{status: ''}"
        >
            @csrf
            <input type="hidden" name="customer_id" value="{{$item->id}}">
            <div class="modal-header">
                <h5 class="modal-title">{{$item->plan->name}} tarifini boshqarish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('admin.subscriptions._subs_modal_base_info', ['item' => $item])
                <div class="mb-4"></div>
                @if($item->status == \App\Models\Plan::STATUS_ACTIVE)
                    @if($item->isExpired() || $item->isExpiresToday())
                        <label class="form-check">
                            <input type="radio" class="form-check-input" @click="status = '{{\App\Models\Plan::STATUS_DEACTIVE}}'" name="status" value="{{\App\Models\Plan::STATUS_DEACTIVE}}">
                            <span class="form-check-label">Deaktiv qilish</span>
                            <span class="form-check-description">Obuna vaqtincha to'xtatiladi</span>
                        </label>
                    @endif
                    <label class="form-check">
                        <input type="radio" class="form-check-input" @click="status = '{{\App\Models\Plan::STATUS_CLOSED}}'" name="status" value="{{\App\Models\Plan::STATUS_CLOSED}}">
                        <span class="form-check-label">Obunani tugatish</span>
                        <span class="form-check-description">To'lov to'liq qabul qilingan yoki qilinadi</span>
                    </label>
                    <label class="form-check">
                        <input type="radio" class="form-check-input" @click="status = '{{\App\Models\Plan::STATUS_CANCELLED}}'" name="status" value="{{\App\Models\Plan::STATUS_CANCELLED}}">
                        <span class="form-check-label">Obunani bekor qilish</span>
                        <span class="form-check-description">To'lov to'liq qabul qilinmagan yoki qilinmaydi</span>
                    </label>
                @endif
                <div x-show="status === '{{\App\Models\Plan::STATUS_CANCELLED}}'">
                    <div class="col-12 mb-3">
                        <label class="form-label">Qabul qilingan to'lov qiymatini ko'rsating UZS <sup class="fw-bold text-danger">*</sup></label>
                        <input type="number" class="form-control w-50" placeholder="0 - {{$item->cost}} UZS" name="cancelled_with_paid_sum" min="0" max="{{$item->cost}}" :required="status === '{{\App\Models\Plan::STATUS_CANCELLED}}'">
                        <span class="form-check-description">Ko'rsatilgan summa asosida to'lanmagan qiymat hisoblanib va shartnoma umumiy summasidan olib tashlanadi va keyingi to'lovlar uchun xisoblanmaydi</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" @click="status = ''" data-bs-dismiss="modal">
                    Yopish
                </a>
                <button x-show="status" class="btn btn-primary ms-auto" @if($item->status != \App\Models\Plan::STATUS_ACTIVE) type="button" data-bs-dismiss="modal" @endif>
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                    Saqlash
                </button>
            </div>
        </form>
    </div>
</div>
