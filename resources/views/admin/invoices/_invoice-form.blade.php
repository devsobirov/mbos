<div class="modal modal-blur fade" id="invoice-form-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('invoices.update', $item->id)}}" class="modal-content" method="POST"
              x-data="{status: '{{$item->status}}'}"
        >
            @csrf
            <input type="hidden" name="customer_id" value="{{$item->id}}">
            <div class="modal-header">
                <h5 class="modal-title">#{{$item->number}} shartnomani boshqarish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2"><span class="pe-3">Holati: </span> <span class="badge {{$item->getStatusClass()}}">{{$item->getStatusName()}}</span></div>
                <div class="mb-2"><span class="pe-3">Summa: </span> {{$item->total_cost}} UZS</div>
                <div class="mb-2"><span class="pe-3">Bekor qilingan summa: </span> {{(int) $item->total_cancelled}} UZS</div>
                <div class="mb-2"><span class="pe-3">Chegirma UZS: </span> {{(int) $item->fixed_discount}} UZS</div>
                <div class="mb-2"><span class="pe-3">Chegirma %: </span> {{(float) $item->percent_discount}} % ({{(int)$item->percent_discount_sum}} UZS) </div>
                <div class="mb-2"><span class="pe-3">Chegirma jami: </span> {{(int) $item->total_discount}} UZS </div>
                <div class="mb-2"><span class="pe-3">Izoh: </span> {!! $item->notes !!}</div>

                <div class="mb-4"></div>
                @if($item->status == \App\Models\Invoice::STATUS_ACTIVE)
                    <label class="form-check">
                        <input type="radio" class="form-check-input" @click="status = '{{\App\Models\Invoice::STATUS_ACTIVE}}'" name="status" value="{{\App\Models\Invoice::STATUS_ACTIVE}}"
                            @if($item->status == \App\Models\Invoice::STATUS_ACTIVE) checked @endif>
                        <span class="form-check-label">Shartnoma aktiv</span>
                    </label>

                    <div class="alert alert-important alert-danger alert-dismissible" role="alert" x-cloak x-show="status !== '{{\App\Models\Invoice::STATUS_ACTIVE}}'">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                            </div>
                            <div>Shartnoma tugatilsa yo bekor qilinsa unga tegishli barcha xizmat va tariflar xam tegishli statusga o'tkaziladi,
                                shartnoma uchun to'lov qabul qilish yoki yangi tariflar kiritish mumkin bolmaydi.
                            </div>
                        </div>
                    </div>

                    <label class="form-check">
                        <input type="radio" class="form-check-input" @click="status = '{{\App\Models\Invoice::STATUS_CLOSED}}'" name="status" value="{{\App\Models\Invoice::STATUS_CLOSED}}">
                        <span class="form-check-label">Shartnomani tugatish</span>
                        <span class="form-check-description">To'lov to'liq qabul qilingan yoki qoidalari buzilmagan</span>
                    </label>
                    <label class="form-check">
                        <input type="radio" class="form-check-input" @click="status = '{{\App\Models\Invoice::STATUS_CANCELLED}}'" name="status" value="{{\App\Models\Invoice::STATUS_CANCELLED}}">
                        <span class="form-check-label">Shartnomani bekor qilish</span>
                        <span class="form-check-description">To'lov to'liq qabul qilinmagan yoki qoidalari buzilgan</span>
                    </label>

                    @if($item->next_payment_date)
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label class="form-label">Keyingi to'lov uchun belgilangan sana<sup class="fw-bold text-danger">*</sup></label>
                        <input type="date" class="form-control" name="next_payment_date" value="{{$item->next_payment_date->format('Y-m-d')}}" required>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Izoh</label>
                        <textarea class="form-control" name="notes" data-bs-toggle="autosize" placeholder="Izoh…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 59.6px;">{!! $item->notes !!}</textarea>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" @click="status = ''" data-bs-dismiss="modal">
                    Yopish
                </a>
                <button x-show="status" class="btn btn-primary ms-auto"
                        @if($item->status != \App\Models\Invoice::STATUS_ACTIVE)
                        type="button" data-bs-dismiss="modal"
                        @else
                            @click="if (!confirm('Kiritlgan ma\'lumotlar tog\'riligiga amin bo\'lsangiz, jarayonni tasdiqlang'))return false;"
                        @endif
                >
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                    Saqlash
                </button>
            </div>
        </form>
    </div>
</div>
