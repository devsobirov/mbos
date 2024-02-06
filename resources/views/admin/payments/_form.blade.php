<div class="modal modal-blur fade" id="payemnt-form-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div x-data="paymentFormData()" class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('invoices.create')}}" class="modal-content" method="POST">
            @csrf
            <input type="hidden" name="invoice_id" value="{{$item->id}}">
            <input type="hidden" name="customer_id" value="{{$item->customer_id}}">
            <div class="modal-header">
                <h5 class="modal-title">#{{$item->number}} shartnoma uchun to'lov yaratish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Loyihani tanlang</label>
                            <select type="text" name="project_id" required class="form-select"
                                    x-model="form.project_id" @change="form.plan_id = null; setPlans();">
                                <option :value="null" :selected="!form.project_id" disabled>Tanlang</option>
                                <template x-show="projectList.length" x-for="item in projectList" :key="item.id">
                                    <option :value="item.id" x-text="item.name"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3" x-show="form.project_id" x-cloak>
                            <label class="form-label">Tarif planni tanlang</label>
                            <template x-show="form.project_id && plansList.length" x-for="item in plansList">

                            </template>
                            <p x-cloak x-show="!plansList.length">Tarif planlar topilmadi</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label class="form-label">Reja qilingan sanasi<sup class="fw-bold text-danger">*</sup></label>
                        <input type="date" class="form-control" name="start_date" x-model="invoice.start_date" @change="setExpirationDate()">
                    </div>
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label class="form-label">Keyingi to'lov sanasi<sup class="fw-bold text-danger">*</sup></label>
                        <input type="date" class="form-control" name="expire_date" readonly x-model="invoice.expire_date">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Bekor qilish
                </a>
                <button class="btn btn-primary ms-auto" :class="isValid() ? '' : 'hidden'"
                        @click="if (!confirm('Shartnomani o\'chirish mumkin emas, agar kiritlgan ma\'lumotlar tog\'riligiga amin bo\'lsangiz, jarayonni tasdiqlang'))return false;"
                ><x-svg.plus></x-svg.plus> Saqlash
                </button>
            </div>
        </form>
    </div>
</div>
