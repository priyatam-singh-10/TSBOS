@extends('layouts' . '.' . get_frontend_settings('theme'))
@push('title', get_phrase('Email Verification'))
@push('meta')@endpush
@push('css')
@endpush
@section('content')
    <!------------------- Login Area Start  ------>
    <section class="login-area section-padding">
        <div class="container">
            <div class="login-container">
                <div class="login-card">
                    <form action="{{ route('verification.send') }}" class="global-form login-form" method="POST">
                        @csrf
                        <div class="text-center">
                            <h4 class="g-title">{{ get_phrase('Email Verification') }}</h4>
                            <p class="description">{{ get_phrase('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }} </p>
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <p class="description mt-4 text-success">{{ get_phrase('A new verification link has been sent to the email address you provided during registration.') }}</p>
                        @endif
                        
                        <button type="submit" class="btn-submit w-100 mt-5">{{ get_phrase('Resend Verification Email') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Login Area End  ------>
@endsection
@push('js')

@endpush

