@extends('layouts.app')

@section('content')
{{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}" /> --}}
<script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
    <div id="app">
        <passport-clients></passport-clients>
        <passport-authorized-clients></passport-authorized-clients>
        <passport-personal-access-tokens></passport-personal-access-tokens>
    </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
@endsection