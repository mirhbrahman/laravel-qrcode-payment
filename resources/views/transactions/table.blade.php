<table class="table table-responsive" id="transactions-table">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Buyer</th>
            <th>Method</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>{!! $transaction->qrcode->product_name !!}
            <small> | {{ $transaction->created_at->format('D d, M, Y, h:i') }}</small>
            </td>
            <td>{!! $transaction->user->name !!}</td>
            <td>{!! $transaction->payment_method !!}</td>
            <td>${!! $transaction->amount !!}</td>
            <td>{!! $transaction->status !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('transactions.show', [$transaction->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>