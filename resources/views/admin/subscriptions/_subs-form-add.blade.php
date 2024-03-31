<div class="modal modal-blur fade" id="subs-form-add" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" x-data="invoiceFormData">
        <form action="{{route('invoice-item.add-subs', $invoice->id)}}" class="modal-content" method="POST">
            <div class="modal-header">
                <h5 class="modal-title">#{{$invoice->number}} shartnoma uchun yangi obuna kiritish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="col-md-12">
                    <div class="mb-3" x-show="form.project_id" x-cloak>
                        <label class="form-label">Obuna planini tanlang</label>
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

                    <div class="row" x-cloak x-show="currentPlan">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label">Tarif plan kuchga kirish sanasi<sup class="fw-bold text-danger">*</sup></label>
                            <input type="date" class="form-control" name="start_date" x-model="invoice.start_date" @change="setExpirationDate()">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label">Tarif plan tugash sanasi<sup class="fw-bold text-danger">*</sup></label>
                            <input type="date" class="form-control" name="expire_date" readonly x-model="invoice.expire_date">
                        </div>
                    </div>
                </div>
                <div x-cloak x-show="currentPlan">
                    <div class="row" x-cloak x-show="calcTotalCost()">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <label class="form-label">Chegirma qo'llash - UZS<sup class="fw-bold text-danger">*</sup></label>
                            <input type="number" class="form-control" name="fixed_discount" x-model="invoice.base_discount" min="0" :max="calcTotalCost()-1000">
                        </div>
                        <div class="col-md-8 col-sm-12 mb-3" x-cloak x-show="invoice.base_discount">
                            <label class="form-label">Chegirma <sup class="fw-bold text-danger">*</sup></label>
                            <input type="text" class="form-control" readonly :value="`- ${invoice.base_discount} UZS`">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label class="form-label">Dastlabki to'lov uchun belgilangan sana<sup class="fw-bold text-danger">*</sup></label>
                        <input type="date" class="form-control" name="next_payment_date" x-model="invoice.next_payment_date" required>
                    </div>
                    <p class="d-flex justify-content-between mb-1" :class="currentPlan ? 'd-flex' : 'd-none'"><span>Tarif (asosiy):</span><span x-text="`+ ${calcBaseCost()} UZS`"></span></p>
                    <p class="justify-content-between mb-1" :class="currentPlan.has_extra ? 'd-flex' : 'd-none'"><span>Tarif (qo'shimcha):</span><span x-text="`+ ${calcExtraCost()}`"></span></p>
                    <p class="justify-content-between mb-1" :class="calcTotalDiscount() ? 'd-flex' : 'd-none'"><span>Chegirma (jami): </span><span x-text="`- ${calcTotalDiscount()}`"></span></p>
                    <p class="d-flex justify-content-between mb-1"><span>Jami to'lovga: </span> <span x-text="calcTotalCost()"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" @click="status = ''" data-bs-dismiss="modal">
                    Bekor qilish
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
<script>
    function defaultInvoice() {
        return {
            base_qty: 1,
            base_cost: null,
            base_discount: 0,
            percent_discount: 0,
            extra_cost: 0,
            extra_discount: 0,
            extra_qty: 0,
            start_date: null,
            expire_date: null,
            next_payment_date: "{{$invoice->next_payment_date->format('Y-m-d')}}",
        }
    }
    function invoiceFormData() {
        return {
            plansList: [],
            currentPlan: false,
            plan: null,
            form: {project_id: parseInt('{{$invoice->project->id}}'), plan_id: null},
            invoice: defaultInvoice(),
            init() {
                this.plansList = @json($subscriptions);
            },
            setCurrentPlan() {
                this.invoice = defaultInvoice();
                if (this.plansList.length) {
                    this.plansList.forEach(item => {
                        if (item.id === parseInt(this.form.plan_id)) {
                            this.currentPlan = item;
                        }
                    })
                }
            },
            calcBaseCost() {
                if (this.currentPlan) {
                    return Math.floor(this.invoice.base_qty * this.currentPlan.price);
                }

                return 0;
            },
            calcExtraCost() {
                if (this.currentPlan && this.currentPlan.has_extra) {
                    return Math.floor(this.invoice.extra_qty * this.invoice.base_qty * this.currentPlan.per_extra_price);
                }

                return 0;
            },
            calcTotalCostWithoutDiscount() {
                return Math.floor(
                    this.calcBaseCost() + this.calcExtraCost()
                );
            },
            calcTotalDiscount() {
                return Math.round(
                    parseInt(this.invoice.base_discount)
                )
            },
            calcTotalCost() {
                return Math.floor(
                    this.calcTotalCostWithoutDiscount() - this.calcTotalDiscount()
                );
            },
            setExpirationDate() {
                if (this.invoice.base_qty && this.invoice.start_date) {
                    // Parse the start date string to a Date object
                    const startDateObj = new Date(this.invoice.start_date);

                    // Add the base quantity (in months) to the start date
                    startDateObj.setMonth(startDateObj.getMonth() + parseInt(this.invoice.base_qty));

                    // Format the modified date as a string in the format "YYYY-MM-DD"
                    this.invoice.expire_date = startDateObj.toISOString().split('T')[0];
                    return true;
                }
                this.invoice.expire_date = null;
            },
            isValid() {
                return !!this.invoice.base_qty
                    && !!this.form.project_id
                    &&  (this.currentPlan && this.invoice.start_date && this.invoice.expire_date)
                    && this.invoice.next_payment_date
            }
        }
    }
</script>
