<div class="col-md-6">

    <!-- Name Field -->
    <div class="form-group">
        {!! Form::label('name', 'Name:') !!}
        <p>{!! $user->name !!}</p>
    </div>

    <!-- Role Id Field -->
    <div class="form-group">
        {!! Form::label('role_id', 'User Level:') !!}
        <p>{!! $user->role->name !!}</p>
    </div>

</div>
<div class="col-md-6">

    <!-- Email Field -->
    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        <p>{!! $user->email !!}</p>
    </div>


    <!-- Created At Field -->
    <div class="form-group">
        {!! Form::label('created_at', 'Join:') !!}
        <p>{!! $user->created_at->format('D d, M, Y h:i') !!}</p>
    </div>
</div>




@if ($user->id == Auth::user()->id || Auth::role_id
< 3) <div class="col-md-12">
    <h3 class="text-center">Transactions</h3>
    @include('transactions.table')
    </div>
    <div class="col-md-12">
        <h3 class="text-center">QRCodes</h3>
    @include('qrcodes.table')
    </div>
    @endif