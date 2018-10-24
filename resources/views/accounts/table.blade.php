<table class="table table-responsive" id="accounts-table">
    <thead>
        <tr>
            <th>User</th>
            <th>Balance</th>
            <th>Total Credit</th>
            <th>Total Debit</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($accounts as $account)
        <tr>
            <td>
                <a href="{!! route('users.show', [$account->user_id]) !!}" class='btn btn-default btn-xs'>
                    {!! $account->user->email !!}
                </a>
            </td>
            <td>${!! number_format($account->balance) !!}</td>
            <td>${!! number_format($account->total_credit) !!}</td>
            <td>${!! number_format($account->total_debit) !!}</td>
            <td>
                @if ($account->applied_for_payout == 1)
                    Payment Pending
                @elseif($account->paid == 1)
                    Paid
                @endif
            </td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('accounts.show', [$account->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('accounts.edit', [$account->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>