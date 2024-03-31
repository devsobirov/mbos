<div class="modal modal-blur fade" id="service-form-add" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" x-data="serviceFormData">
        <form action="{{route('invoice-item.add-service', $invoice->id)}}" class="modal-content" method="POST">
            <div class="modal-header">
                <h5 class="modal-title">#{{$invoice->number}} shartnoma uchun yangi obuna kiritish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
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
                                            <input type="number" style="width: 80px" class="form-control" :name="'services[' + service.id + '][qty]'" x-model="service.amount" :disabled="!services.includes(service.id.toString())">
                                            <div x-text="service.unit"></div>
                                            <div x-text="'+' + getServiceCost(service.id) + ' UZS'"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" :name="'services[' + service.id + '][cost]'" :value="getServiceCost(service.id)" :disabled="!services.includes(service.id.toString())">
                                </div>
                            </template>
                        </div>
                    </div>
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
                    <div class="col-md-6 col-sm-12 mb-3" x-cloak x-show="calcTotalCost()">
                        <label class="form-label">Dastlabki to'lov uchun belgilangan sana<sup class="fw-bold text-danger">*</sup></label>
                        <input type="date" class="form-control" name="next_payment_date" x-model="invoice.next_payment_date" required>
                    </div>
                    <p class="d-flex justify-content-between mb-1" :class="services.length ? 'd-flex' : 'd-none'"><span>Xizamtlar:</span><span x-text="`+ ${getServicesSum()} UZS`"></span></p>
                    <p class="justify-content-between mb-1" :class="calcTotalDiscount() ? 'd-flex' : 'd-none'"><span>Chegirma (jami): </span><span x-text="`- ${calcTotalDiscount()} UZS`"></span></p>
                    <p class="d-flex justify-content-between mb-1" :class="calcTotalCost() ? 'd-flex' : 'd-none'"><span>Jami to'lovga: </span> <span x-text="calcTotalCost() + ' UZS'"></span></p>
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
            next_payment_date: "{{$invoice->next_payment_date->format('Y-m-d')}}",
        }
    }
    function serviceFormData() {
        return {
            services: [],
            serviceList: [],
            invoice: defaultInvoice(),
            init() {
                this.serviceList = @json($services);
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
            calcTotalCostWithoutDiscount() {
                return Math.floor(
                    this.getServicesSum()
                );
            },
            calcTotalDiscount() {
              return parseInt(this.invoice.base_discount)
            },
            calcTotalCost() {
                return Math.floor(
                    this.calcTotalCostWithoutDiscount() - this.calcTotalDiscount()
                );
            },
            isValid() {
                return !!this.calcTotalCost() && this.invoice.next_payment_date;
            }
        }
    }
</script>
