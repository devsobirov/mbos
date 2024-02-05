<div class="modal modal-blur fade" id="invoice-form-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div x-data="invoiceFormData()" class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('invoices.create')}}" class="modal-content" method="POST">
            @csrf
            <input type="hidden" name="customer_id" value="{{$item->id}}">
            <div class="modal-header">
                <h5 class="modal-title">{{$item->name}} uchun yangi shartnoma yaratish</h5>
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
                                <div>
                                    <label class="form-check">
                                        <input class="form-check-input" name="plan_id" type="radio" :value="item.id" x-model="form.plan_id" @change="setCurrentPlan()">
                                        <span class="form-check-label" x-text="item.name"></span>
                                        <span class="form-check-description" x-text="item.description"></span>
                                    </label>
                                </div>
                            </template>
                            <p x-cloak x-show="!plansList.length">Tarif planlar topilmadi</p>
                        </div>
                    </div>
                </div>
                <div x-cloak x-show="currentPlan">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <label class="form-label"><span x-text="`Asosiy xizmat (${currentPlan.unit}) miqdori`"></span> <sup class="fw-bold text-danger">*</sup></label>
                            <input type="number" class="form-control" name="base_qty" required x-model="invoice.base_qty" min= mb-11">
                        </div>
                        <div class="col-md-8 col-sm-12 mb-3">
                            <label class="form-label">Asosiy xizmat narxi <sup class="fw-bold text-danger">*</sup></label>
                            <input type="text" class="form-control" readonly
                                   :value="`Xar ${currentPlan.amount} ${currentPlan.unit} uchun ${currentPlan.price} sumdan ${Math.floor(invoice.base_qty * currentPlan.amount)} ${currentPlan.unit} uchun ${calcBaseCost()} sum`">
                            <input type="hidden" name="base_cost" x-model="calcBaseCost()">
                        </div>
                    </div>
                    <div class="row" x-cloak x-show="currentPlan && currentPlan.has_extra">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <label class="form-label">Qo'shimcha xizmat (xodim) miqdori<sup class="fw-bold text-danger">*</sup></label>
                            <input type="number" class="form-control" name="extra_qty" required x-model="invoice.extra_qty" min="0" @change="setExpirationDate()">
                        </div>
                        <div class="col-md-8 col-sm-12 mb-3" x-cloak x-show="calcExtraCost()">
                            <label class="form-label">Qo'shimcha xizmat narxi <sup class="fw-bold text-danger">*</sup></label>
                            <input type="text" class="form-control" readonly
                                   :value="`Xar ${currentPlan.per_extra_amount} birlik uchun ${currentPlan.per_extra_price} sumdan ${Math.floor(invoice.base_qty * currentPlan.amount)} ${currentPlan.unit} uchun ${calcExtraCost()} sum`">
                            <input type="hidden" name="extra_cost" x-model="calcBaseCost()">
                        </div>
                    </div>
                    <div class="row" x-cloak x-show="currentPlan && calcTotalCost()">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <label class="form-label">Chegirma qo'llash<sup class="fw-bold text-danger">*</sup></label>
                            <input type="number" class="form-control" name="base_discount" x-model="invoice.base_discount" min="0" :max="calcBaseCost()+calcExtraCost()-1000">
                        </div>
                        <div class="col-md-8 col-sm-12 mb-3" x-cloak x-show="invoice.base_discount">
                            <label class="form-label">Chegirma <sup class="fw-bold text-danger">*</sup></label>
                            <input type="text" class="form-control" readonly :value="`- ${invoice.base_discount} sum`">
                        </div>
                    </div>
                    <div class="row" x-cloak x-show="currentPlan">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label">Tarif plan kuchga kirish sanasi<sup class="fw-bold text-danger">*</sup></label>
                            <input type="date" class="form-control" name="start_date" x-model="invoice.start_date" @change="setExpirationDate()">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label">Tarif plan tugash sanasi<sup class="fw-bold text-danger">*</sup></label>
                            <input type="date" class="form-control" name="expire_date" readonly x-model="invoice.expire_date">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3" x-show="currentPlan.has_expiration">
                            <label class="form-label">Dastlabki to'lov uchun belgilangan sana<sup class="fw-bold text-danger">*</sup></label>
                            <input type="date" class="form-control" name="next_payment_date" x-model="invoice.next_payment_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Izoh</label>
                        <textarea class="form-control" name="notes" data-bs-toggle="autosize" placeholder="Izoh…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 59.6px;"></textarea>
                    </div>

                    <hr>
                    <div class="mb-3 w-50">
                        <p class="d-flex justify-content-between mb-1"><span>Asosiy narx:</span><span x-text="`+ ${calcBaseCost()}`"></span></p>
                        <p class="justify-content-between mb-1" :class="currentPlan.has_extra ? 'd-flex' : 'd-none'"><span>Qo'shimcha narx:</span><span x-text="`+ ${calcExtraCost()}`"></span></p>
                        <p class="justify-content-between mb-1" :class="invoice.base_discount ? 'd-flex' : 'd-none'"><span>Chegirma: </span><span x-text="`- ${invoice.base_discount}`"></span></p>
                        <p class="d-flex justify-content-between mb-1"><span>Jami: </span> <span x-text="calcTotalCost()"></span></p>
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
