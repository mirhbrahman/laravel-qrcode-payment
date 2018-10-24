@extends('layouts.app')

@section('content')
    <section class="content-header">
        @include('flash::message')
        <h1 class="pull-left">
            Account <small>
                @if ($account->applied_for_payout == 1 && $account->paid == 0)
                Payout request pending
                @endif
            </small>
        </h1>
        <div class="col-md-6 pull-right">
            @if (Auth::user()->id == $account->user_id && $account->applied_for_payout != 1)
                {!! Form::open(['route' => ['accounts.apply_for_payout', $account->id], 'method' => 'post']) !!}
                    <input type="hidden" value="{{ $account->id }}" name="apply_for_payout">
                    {!! Form::button('<i class="fa fa-credit-card"> Apply for payout</i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-right']) !!}
                {!! Form::close() !!}
            @endif

            @if (Auth::user()->role_id < 3 && $account->applied_for_payout == 1)
                {!! Form::open(['route' => ['accounts.mark_as_paid', $account->id], 'method' => 'post']) !!}
                    <input type="hidden" value="{{ $account->id }}" name="mark_as_paid">    
                    {!! Form::button('<i class="fa fa-check"> Mark as paid</i>', ['type' => 'submit', 'class' => 'btn btn-success pull-right', 'style' => 'margin-right:10px']) !!}
                {!! Form::close() !!}
            @endif
            
        </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('accounts.show_fields')
                    <a href="{!! route('accounts.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
