<div class="card-table table-responsive">
    <table class="table table-vcenter">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nomi</th>
            <th>Bazaviy miqdor/summa</th>
            <th>Qo'shimcha miqdor/summa</th>
            <th>Jami summa UZS</th>
            <th>Boshlanish muddati</th>
            <th>Tugash muddati</th>
            <th>Status</th>
            <th>Sana</th>
            <th></th>
        </tr>
        </thead>
        @forelse($subscriptions as $item)
            <tr>
                <td>ID: {{ $item->id }}</td>
                <td>{{$item->plan->name}}</td>
                <td>{{$item->qty}} {{$item->plan->unit}} / {{$item->base_price}} UZS</td>
                <td>{{$item->extra_qty}} xodim / {{$item->extra_price}} UZS</td>
                <td>{{$item->cost}} UZS</td>
                <td>{{$item->start_date ? $item->start_date->format('d-M-Y') : ''}}</td>
                <td>
                    {{$item->expire_date ? $item->expire_date->format('d-M-Y') : ''}} <br>
                    @if($forHuman = $item->left_days_for_human)
                        <span class="badge {{$item->left_days_class}}">{{$forHuman}}</span>
                    @endif
                </td>
                <td>
                    @if($item->isExpired())
                        <span class="badge {{$item->left_days_class}}">Qarzga o'tgan ({{$item->days_left}} kun)</span><br>
                    @endif
                    <span class="badge {{$item->getStatusClass()}}">{{$item->getStatusName()}}</span>
                </td>
                <td>
                    <a href="#" data-bs-target="#subs-form-{{$item->id}}" data-bs-toggle="modal" class="btn btn-icon btn-warning" title="Boshqarish">
                        <x-svg.settings-sm></x-svg.settings-sm>
                    </a>
                    @if(in_array($item->status, [\App\Models\Plan::STATUS_ACTIVE, \App\Models\Plan::STATUS_DEACTIVE]))
                        <a href="#" data-bs-target="#subs-form-add-{{$item->id}}" data-bs-toggle="modal" class="btn btn-icon btn-success" title="Uzaytirish">
                            <x-svg.plus></x-svg.plus>
                        </a>
                        @include('admin.subscriptions._sub-form-continue', ['item' => $item])
                    @endif
                    @include('admin.subscriptions._subs-form', ['item' => $item])
                </td>
            </tr>
        @empty
            <tr><td colspan="10" class="text-center">Obuna tariflari topilmadi</td></tr>
        @endforelse
    </table>
</div>
<script>
    function continuePlanData(date1, date2, price) {
        return {
            initialQty: null,
            monthlySum: price,
            base_qty: 0,
            start_date: date1,
            expire_date: date2,
            setExpirationDate() {
                if (this.base_qty && this.start_date) {
                    let total = this.initialQty + parseInt(this.base_qty);
                    // Parse the start date string to a Date object
                    const startDateObj = new Date(this.start_date);

                    // Add the base quantity (in months) to the start date
                    startDateObj.setMonth(startDateObj.getMonth() + parseInt(total));

                    // Format the modified date as a string in the format "YYYY-MM-DD"
                    this.expire_date = startDateObj.toISOString().split('T')[0];
                    return true;
                }
                this.expire_date = null;
            },
            isValid() {
                return this.base_qty && this.expire_date;
            }
        }
    }
</script>
