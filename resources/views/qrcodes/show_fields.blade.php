<div class="col-md-6">
    <!-- Product Name Field -->
    <div class="form-group">
        {!! Form::label('product_name', 'Product Name:') !!}
        <h3 style="margin:0">{!! $qrcode->product_name !!}</h3>
        @if (isset($qrcode->company_name))
        <small>By {!! $qrcode->company_name !!}</small> @endif
    </div>

    <!-- Amount Field -->
    <div class="form-group">
        <h4>Amount ${!! $qrcode->amount !!}</h4>
    </div>

    <!-- Product Url Field -->
    <div class="form-group">
        {!! Form::label('product_url', 'Product Url:') !!}
        <a href="{!! $qrcode->product_url !!}" target="_blank">
            <p>{!! $qrcode->product_url !!}</p>
        </a>
    </div>

    @if (!Auth::guest() && ($qrcode->user_id == Auth::user()->id || Auth::user()->role_id
    < 3)) <hr />
    <!-- User Field -->
    <div class="form-group">
        {!! Form::label('user_name', 'User Name:') !!}
        <p>{!! $qrcode->user->name !!}</p>
    </div>

    <!-- Website Field -->
    <div class="form-group">
        {!! Form::label('website', 'Website:') !!}
        <p>{!! $qrcode->website !!}</p>
    </div>

    <!-- Callback Url Field -->
    <div class="form-group">
        {!! Form::label('callback_url', 'Callback Url:') !!}
        <p>{!! $qrcode->callback_url !!}</p>
    </div>

    <!-- Status Field -->
    <div class="form-group">
        {!! Form::label('status', 'Status:') !!}
        <p>{!! $qrcode->status ? 'Active' : 'Inactive' !!}</p>
    </div>

    <!-- Created At Field -->
    <div class="form-group">
        {!! Form::label('created_at', 'Created At:') !!}
        <p>{!! $qrcode->created_at->format('D d, M, Y h:i') !!}</p>
    </div>
    @endif

</div>
<div class="col-md-5">
    <!-- Qrcode Path Field -->
    <div class="form-group">
        {!! Form::label('qrcode_path', 'Scan Qrcode:') !!}
        <p>
            <img src="{{ asset($qrcode->qrcode_path) }}" alt="">
        </p>
    </div>

    @if (!Auth::guest())
    @include('qrcodes.paystack-form')
    @else
    You need to login to pay
    @endif

</div>


@if (!Auth::guest() && ($qrcode->user_id == Auth::user()->id || Auth::user()->role_id
< 3)) <div class="col-md-12">
    <h3 class="text-center">Transactions done on this QRCode</h3>
    @include('transactions.table')
    </div>
    @endif