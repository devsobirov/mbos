<div class="card-table table-responsive">
    <table class="table table-vcenter">
        <thead>
        <tr>
            <th>ID</th>
            <th>Loyiha</th>
            <th>Miqdori</th>
            <th>Boshlanish muddati</th>
            <th>Tugash muddati</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($payments as $payment)
        <tr>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Shartnoma uchun to'lov checklari topilmadi</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>
