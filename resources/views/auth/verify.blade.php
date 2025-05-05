@extends('layouts.app')

@section('content')
<div class="card-body login-card-body pb-5">
    <p class="login-box-msg">{{ __('Verify Your Email Address') }}</p>

    @if (session('resent'))
    <div class="alert alert-success" role="alert">
        {{ __('A fresh verification link has been sent to your email address.') }}
    </div>
    @endif

    <p class="text-center">
        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }}
    </p>,
    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary ">{{ __('click here to request another')
                        }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection