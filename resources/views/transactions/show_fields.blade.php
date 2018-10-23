<!-- Id Field -->
<div class="form-group">
    <p>Transaction ID: #{!! $transaction->id !!}</p>
</div>

<!-- Qrcode Id Field -->
<div class="form-group">
    {!! Form::label('qrcode_id', 'Product Name:') !!}
    <p><a href="{{ route('qrcodes.show', $transaction->qrcode_id) }}">{!! $transaction->qrcode->product_name !!}</a></p>
</div>


<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>${!! $transaction->amount !!}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'Buyer Name:') !!}
    <p>{!! $transaction->user->name !!} | {!! $transaction->user->email !!}</p>
</div>


<!-- Qrcode Owner Id Field -->
<div class="form-group">
    {!! Form::label('qrcode_owner_id', 'Qrcode Owner Name:') !!}
    <p>{!! $transaction->qrcode_owner->name !!} | {!! $transaction->qrcode_owner->email !!}</p>
</div>

<!-- Payment Method Field -->
<div class="form-group">
    {!! Form::label('payment_method', 'Payment Method:') !!}
    <p>{!! $transaction->payment_method !!}</p>
</div>

<!-- Message Field -->
<div class="form-group">
    {!! Form::label('message', 'Message:') !!}
    <p>{!! $transaction->message !!}</p>
</div>


<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $transaction->status !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $transaction->created_at->format('D d, M, Y h:i') !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $transaction->updated_at->format('D d, M, Y h:i') !!}</p>
</div>



