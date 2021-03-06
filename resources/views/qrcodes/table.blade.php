<table class="table table-responsive" id="qrcodes-table">
    <thead>
        <tr>
        <th>Product Name</th>
        <th>Company Name</th>
        <th>Website</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($qrcodes as $qrcode)
        <tr>
            <td>
                <b><a class="text-info" href="{!! route('qrcodes.show', [$qrcode->id]) !!}">{!! $qrcode->product_name !!}</a></b>
            </td>
            <td>{!! $qrcode->company_name !!}</td>
            <td>{!! $qrcode->website !!}</td>
            <td>${!! $qrcode->amount !!}</td>
            <td>
                @if ($qrcode->status == 1)
                    <i class="fa fa-check-square text-green"></i>
                @else
                <i class="fa fa-times-circle text-red"></i>
                @endif
            </td>
            <td>
                @if ($qrcode->user_id == Auth::user()->id || Auth::user()->role_id < 3)
                {!! Form::open(['route' => ['qrcodes.destroy', $qrcode->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('qrcodes.show', [$qrcode->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('qrcodes.edit', [$qrcode->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>