@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Shartnoma yaratish
                    </div>
                    <h2 class="page-title">
                        {{ $customer->name }} uchun {{$project->name}} loyihasi shartnomasi yaratish
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <form x-data="invoiceFormData()" action="{{route('invoices.save')}}" class="card-body" method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{$item->id}}">
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <div class="modal-body">
                        <div class="row">
                            <label class="form-label">Xizmat turlarini tanlang</label>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <template x-for="service in serviceList" :key="service.id">
                                        <div class="d-flex align-items-baseline mb-2" style="gap: 20px">
                                            <label class="form-check">
                                                <input type="checkbox" class="form-check-input" x-model="services" :name="'services[' + service.id + ']'" :value="service.id">
                                                <span class="form-check-label" x-text="service.name"></span>
                                                <span class="form-check-description" x-text="service.description"></span>
                                            </label>

                                            <div x-cloak x-show="services.includes(service.id.toString())">
                                                <div class="d-flex align-items-center" style="gap: 10px;">
                                                    <input type="number" style="width: 80px" class="form-control" :name="'services[' + service.id + '][qty]'" required x-model="service.amount" min="1" :disabled="!services.includes(service.id.toString())">
                                                    <div x-text="service.unit"></div>
                                                    <div x-text="'+' + getServiceCost(service.id) + ' UZS'"></div>
                                                </div>
                                            </div>
                                            <input type="hidden" :name="'services[' + service.id + '][cost]'" :value="getServiceCost(service.id)" :disabled="!services.includes(service.id.toString())">
                                        </div>
                                    </template>
                                </div>
                            </div>
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
                    </div>
                    <div class="mb-3 w-50" x-cloak x-show="services.length || currentPlan">

                        <div class="row" x-cloak x-show="calcTotalCost()">
                            <div class="row" x-cloak x-show="calcTotalCost()">
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Chegirma qo'llash - %<sup class="fw-bold text-danger">*</sup></label>
                                    <input type="number" class="form-control" name="percent_discount" x-model="invoice.percent_discount" min="0" max="99">
                                    <input type="hidden" name="percent_discount_sum" :value="calcPercentDiscount()">
                                </div>
                                <div class="col-md-8 col-sm-12 mb-3" x-cloak x-show="invoice.percent_discount">
                                    <label class="form-label">Chegirma <sup class="fw-bold text-danger">*</sup></label>
                                    <input type="text" class="form-control" readonly :value="`- ${calcPercentDiscount()} UZS`">
                                </div>
                            </div>

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
                        <div class="mb-3">
                            <label class="form-label">Izoh</label>
                            <textarea class="form-control" name="notes" data-bs-toggle="autosize" placeholder="Izoh…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 59.6px;"></textarea>
                        </div>
                        <hr>
                        <p class="d-flex justify-content-between mb-1" :class="services.length ? 'd-flex' : 'd-none'"><span>Xizamtlar:</span><span x-text="`+ ${getServicesSum()} UZS`"></span></p>
                        <p class="d-flex justify-content-between mb-1" :class="currentPlan ? 'd-flex' : 'd-none'"><span>Tarif (asosiy):</span><span x-text="`+ ${calcBaseCost()} UZS`"></span></p>
                        <p class="justify-content-between mb-1" :class="currentPlan.has_extra ? 'd-flex' : 'd-none'"><span>Tarif (qo'shimcha):</span><span x-text="`+ ${calcExtraCost()}`"></span></p>
                        <p class="justify-content-between mb-1" :class="calcTotalDiscount() ? 'd-flex' : 'd-none'"><span>Chegirma (jami): </span><span x-text="`- ${calcTotalDiscount()}`"></span></p>
                        <p class="d-flex justify-content-between mb-1"><span>Jami to'lovga: </span> <span x-text="calcTotalCost()"></span></p>
                    </div>
                    <div class="modal-footer" x-show="isValid()">
                        <button class="btn btn-primary ms-auto" :class="isValid() ? '' : 'hidden'"
                                @click="if (!confirm('Shartnomani o\'chirish mumkin emas, agar kiritlgan ma\'lumotlar tog\'riligiga amin bo\'lsangiz, jarayonni tasdiqlang'))return false;"
                        ><x-svg.plus></x-svg.plus> Saqlash
                        </button>
                    </div>
                </form>
            </div>
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
                notes: '',
                next_payment_date: '',
            }
        }
        function invoiceFormData() {
            return {
                services: [],
                serviceList: [],
                plansList: [],
                currentPlan: false,
                project: null,
                plan: null,
                form: {project_id: parseInt('{{$project->id}}'), plan_id: null, services: []},
                invoice: defaultInvoice(),
                init() {
                    this.serviceList = @json($services);
                    this.plansList = @json($subscriptions);
                },
                getServiceCost(id) {
                    let cost = 0;
                    if (this.services.length) {
                        this.serviceList.forEach(i => {
                            if (i.id === parseInt(id)) {
                                cost = i.price * i.amount;
                            }
                        })
                    }
                    return Math.round(cost);
                },
                getServicesSum() {
                  let sum = 0;
                  if (this.services.length) {
                      this.services.forEach(i => sum += this.getServiceCost(i))
                  }
                  return Math.round(sum);
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
                calcPercentDiscount() {
                    if (this.invoice.percent_discount) {
                        return Math.round(
                            (this.getServicesSum() + this.calcBaseCost() + this.calcExtraCost()) * this.invoice.percent_discount /100
                        );
                    }

                    return 0;
                },
                calcTotalCostWithoutDiscount() {
                    return Math.floor(
                        this.getServicesSum() + this.calcBaseCost() + this.calcExtraCost()
                    );
                },
                calcTotalDiscount() {
                    return Math.round(
                        parseInt(this.invoice.base_discount) + this.calcPercentDiscount()
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
                        &&  (
                            this.services.length ||
                            (this.currentPlan && this.invoice.start_date && this.invoice.expire_date)
                        )
                        && this.invoice.next_payment_date
                }
            }
        }
    </script>
@endsection
