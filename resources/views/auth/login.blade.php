@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-lg">
                <div class="bg-santa-maroon text-white hover:bg-santa-gold dark:bg-santa-gold dark:text-santa-maroon text-lg  p-4">{{ __('Login') }}</div>

                <div class="p-6">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="block text-santa-green text-sm font-bold mb-2">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-santa-green text-sm font-bold mb-2">{{ __('Password') }}</label>
                            <input id="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input class="mr-2 leading-tight" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="text-sm" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>

                        <div class="flex items-center justify-center">
                            <button type="submit" class="w-full bg-santa-green hover:bg-santa-gold text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <div class="flex items-center justify-center text-center">
                            @if (Route::has('password.request'))
                                <a class="w-full inline-block text-santa-green align-baseline font-bold text-sm text-santa-maroon hover:text-santa-gold mt-4" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
