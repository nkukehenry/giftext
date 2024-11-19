@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-lg">
                <div class="bg-gray-200 text-lg font-semibold p-4">{{ __('Verify Your Email Address') }}</div>

                <div class="p-6">
                    @if (session('resent'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="text-santa-maroon hover:underline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
