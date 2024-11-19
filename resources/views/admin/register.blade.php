@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-lg">
                <div class="bg-santa-maroon text-white text-lg p-4">{{ __('Create Your Account') }}</div>
               
                <div class="bg-teal-100 border-t-4 border-teal-500 text-teal-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                    <p class="font-bold">Complete the form to create your account</p>
                    <p class="text-sm">{{ __('You will be able to add your colleagues and manage your account after you have created your account.') }}</p>
                    </div>
                </div>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('admin.register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="block text-santa-green text-sm font-bold mb-2">{{ __('Email Address') }}</label>
                            <input id="email" placeholder="Enter your email address" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-santa-green text-sm font-bold mb-2">{{ __('Password') }}</label>
                            <input id="password" placeholder="Enter your password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="group_type" class="block text-santa-green text-sm font-bold mb-2">{{ __('Group Type') }}</label>
                            <select id="group_type" name="group_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="updateInstitutionLabel()">
                                <option value="family">Family</option>
                                <option value="organization">Organization</option>
                                <option value="friends">Friends</option>
                                <option value="event">Event</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="institution_name" class="block text-santa-green text-sm font-bold mb-2" id="institution_label">{{ __('Institution/Organization Name') }}</label>
                            <input id="institution_name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('institution_name') border-red-500 @enderror" name="institution_name" placeholder="Enter your institution/organization name" required>
                            @error('institution_name')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-santa-green hover:bg-santa-gold text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full mt-2">
                                {{ __('Register') }}
                            </button>
                        </div>

                        <div class="flex items-center justify-center text-center">
                            @if (Route::has('password.request'))
                                <a class="w-full inline-block text-santa-green align-baseline font-bold text-sm text-santa-maroon hover:text-santa-gold mt-4" href="{{ url('login') }}">
                                    {{ __('Login Instead') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateInstitutionLabel() {
            const groupType = document.getElementById('group_type').value;
            const institutionLabel = document.getElementById('institution_label');
            const institutionInput = document.getElementById('institution_name');

            switch (groupType) {
                case 'family':
                    institutionLabel.innerText = 'Family Name';
                    institutionInput.placeholder = 'Enter your family name';
                    break;
                case 'organization':
                    institutionLabel.innerText = 'Organization Name';
                    institutionInput.placeholder = 'Enter your organization name';
                    break;
                case 'friends':
                    institutionLabel.innerText = 'Friends Group Name';
                    institutionInput.placeholder = 'Enter your friends group name';
                    break;
                case 'event':
                    institutionLabel.innerText = 'Event Name';
                    institutionInput.placeholder = 'Enter your event name';
                    break;
                case 'other':
                    institutionLabel.innerText = 'What is your cause/purpose?';
                    institutionInput.placeholder = 'Enter your cause/purpose';
                    break;
                default:
                    institutionLabel.innerText = 'Institution/Organization Name';
                    institutionInput.placeholder = 'Enter your institution/organization name';
            }
        }
    </script>
@endsection 