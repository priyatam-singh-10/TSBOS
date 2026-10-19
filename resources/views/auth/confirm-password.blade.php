<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>



@extends('layouts' . '.' . get_frontend_settings('theme'))
@push('title', get_phrase('Confirm Password'))
@push('meta')@endpush
@push('css')
@endpush
@section('content')
    <!------------------- Login Area Start  ------>
    <section class="login-area section-padding">
        <div class="container">
            <div class="login-container">
                <div class="login-card">
                    <form action="{{ route('password.confirm') }}" class="global-form login-form" method="POST">
                        @csrf
                        <div class="text-center">
                            <h4 class="g-title">{{ get_phrase('Confirm Password') }}</h4>
                            <p class="description">{{get_phrase('This is a secure area of the application. Please confirm your password before continuing.')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">{{ get_phrase('Password') }}</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="{{ get_phrase('Enter Your Password') }}">
                        </div>
                        <button type="submit" class="btn-submit w-100 mt-5">{{ get_phrase('Confirm') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Login Area End  ------>
@endsection
@push('js')

@endpush
