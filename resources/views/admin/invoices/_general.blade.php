<table class="table table-vcenter">
    <thead>
    <tr>
        <th>Jami to'lovga tasdiqlangan (UZS)</th>
        <th>To'langan (UZS)</th>
        <th>Qoldiq (UZS)</th>
        <th>So'ngi to'lov</th>
        <th>Keyingi to'lov muddati</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            {{number_format($item->total_cost, 0, ',', ' ')}}
        </td>
        <td>{{number_format($item->total_cost - $item->calculateUnpaidAmount(), 0, ',', ' ')}}</td>
        <td>{{number_format($item->calculateUnpaidAmount(), 0, ',', ' ')}}</td>
        <td>{{$lastPayment ? $lastPayment->created_at->format('d-M-Y') : '-'}}</td>
        <td>{{$item->next_payment_date ? $item->next_payment_date->format('d-M-Y') : ''}}</td>
    </tr>
    </tbody>
    <thead>
    <tr>
        <th>Chegirmalar</th>
        <th>Yaratilgan</th>
        <th>Tahrirlangan</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <td>
        @if(!$item->total_discount)
            -
        @else
            Jami: {{$item->total_discount}} UZS <br>
            @if($item->fixed_discount)
                % - {{$item->percent_discount}}% ({{$item->percent_discount_sum}} UZS) <br>
            @endif
            @if($item->fixed_discount)
                UZS - {{$item->fixed_discount}} UZS
            @endif
        @endif
    </td>
    <td>{{$item->created_at->format('d-M-Y')}}</td>
    <td>{{$item->updated_at->format('d-M-Y')}}</td>
    <td>Aktiv</td>
    <td></td>
    </tbody>
</table>
