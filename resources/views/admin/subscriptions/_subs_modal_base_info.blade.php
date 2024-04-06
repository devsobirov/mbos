<div class="mb-2"><span class="pe-3">Boshlanish muddati:</span> {{$item->start_date ? $item->start_date->format('d-M-Y') : ''}}</div>
<div class="mb-2"><span class="pe-3">Tugash muddati:</span>
    {{$item->expire_date ? $item->expire_date->format('d-M-Y') : ''}} ({{$item->days_left}})
</div>
<div class="mb-2"><span class="pe-3">Holati: </span>
    <span class="badge {{$item->getStatusClass()}}">{{$item->getStatusName()}}</span>
    @if($item->isExpired())
        <span class="badge {{$item->left_days_class}}">Qarzga o'tgan ({{$item->days_left}} kun)</span><br>
    @endif
</div>
<div class="mb-2"><span class="pe-3">Summa: </span> {{$item->cost}} UZS</div>
@if($item->cancelled_at)
    <div class="mb-2"><span class="pe-3">Bekor qilingan:</span> {{$item->cancelled_at->format('d-M-Y')}}</div>
    <div class="mb-2"><span class="pe-3">To'langan summa:</span> {{$item->cancelled_with_paid_sum}} UZS</div>
    <div class="mb-2"><span class="pe-3">Kamomat:</span> <span class="badge bg-danger">{{$item->cancelled_with_paid_sum - $item->cost}} UZS</span></div>
@endif
