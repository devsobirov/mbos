<div class="modal modal-blur fade" id="payment-form" tabindex="-1" aria-modal="true" role="dialog">
    <div x-data="paymentFormData()" class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('payments.save', ['invoice' => $item->id])}}" class="modal-content" method="POST">
            @csrf
            <input type="hidden" name="invoice_id" value="{{$item->id}}">
            <input type="hidden" name="customer_id" value="{{$item->customer_id}}">
            <div class="modal-header">
                <h5 class="modal-title">#{{$item->number}} shartnoma uchun to'lov yaratish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label class="form-label">To'lov summasi (sum) <sup class="fw-bold text-danger">*</sup></label>
                        <input type="number" name="amount" class="form-control" required x-model="amount" min="1000" :max="max_amount" @change="validateAmount(); setLeftAmount();">
                        <p class="fst-italic" x-text="`Qoldiq summa- ${amount_left} sum`"></p>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <label class="form-label">To'lov turi <sup class="fw-bold text-danger">*</sup></label>
                        @foreach(\App\Helpers\PaymentTypeHelper::getTypeList() as $id => $name)
                        <div>
                            <label class="form-check">
                                <input class="form-check-input" name="type" type="radio" required value="{{$id}}" x-model="type">
                                <span class="form-check-label">{{$name}}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label class="form-label">Reja qilingan to'lov sanasi<sup class="fw-bold text-danger">*</sup></label>
                        <input type="date" class="form-control" name="payment_for_date" readonly x-model="payment_for_date" required>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-3" x-show="!!amount_left">
                        <label class="form-label">Keyingi to'lov sanasi<sup class="fw-bold text-danger">*</sup></label>
                        <input type="date" class="form-control" name="next_payment_date" :min="payment_for_date" x-model="next_payment_date" :required="!!amount_left">
                    </div>
                </div>
                <div class="col-sm-12 mb-3">
                    <label class="form-label">To'lov maqsadi (izoh)<sup class="fw-bold text-danger">*</sup></label>
                    <input type="text" class="form-control" name="reason" placeholder="Aprel oyi uchun rejali shartnoma to'lovi ..." required>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Ma'sul<sup class="fw-bold text-danger">*</sup></label>
                    <input type="text" class="form-control" value="{{auth()->user()->name}}" readonly disabled required>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Bekor qilish
                </a>
                <button class="btn btn-primary ms-auto" :class="isValid() ? '' : 'hidden'" x-show="isValid()"
                        @click="if (!confirm('To\'lovni o\'chirish mumkin emas, agar kiritlgan ma\'lumotlar tog\'riligiga amin bo\'lsangiz, jarayonni tasdiqlang'))return false;"
                ><x-svg.plus></x-svg.plus> Saqlash
                </button>
            </div>
        </form>
    </div>
</div>
