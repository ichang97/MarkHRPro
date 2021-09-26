@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} <br>

                    @if(isset($user) && empty($user->line_access_token))
                        <a href="{{route('line-auth')}}" class="btn btn-primary">Go to LINE auth</a>
                    @else
                        <h4 style="color: green;">LINE ACCOUNT IS ACTIVATED.</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
