<div class="card-table table-responsive">
    <table class="table table-vcenter">
        <thead>
        <tr>
            <th>ID</th>
            <th>Reja sanasi</th>
            <th>To'lov sanasi</th>
            <th>To'lov turi</th>
            <th>To'lov summasi</th>
            <th>Qoldiq summa</th>
            <th>Status</th>
            <th>Ma'sul</th>
        </tr>
        </thead>
        <tbody>
        @forelse($payments as $payment)
        <tr>
            <td>#{{$payment->number}}</td>
            <td>{{$payment->payment_for_date->format('d-M-Y')}}</td>
            <td>{{$payment->created_at->format('d-M-Y')}}</td>
            <td>{{$payment->getPaymentType()}}</td>
            <td>{{$payment->amount}}</td>
            <td>{{$payment->left_amount}}</td>
            <td><span class="badge {{$payment->getStatusClass()}}">{{$payment->getStatusName()}}</span></td>
            <td>{{$payment->author->name}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Shartnoma uchun to'lov checklari topilmadi</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>
