<x-guest-layout>
    <div class="container">
        <h2 class="font-semibold text-gray-800 leading-tight">
            {{ __('Registration') }}
        </h2>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="name" :value="__('Name')"/>
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                         autofocus/>
            </div>

            <!-- Email Address -->
            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="email" :value="__('Email')"/>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required/>
            </div>

            <!-- Password -->
            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="password" :value="__('Password')"/>
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                         autocomplete="new-password"/>
            </div>

            <!-- Confirm Password -->
            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')"/>
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                         name="password_confirmation"
                         required/>
            </div>

            <!-- Url from Vetmanager -->
            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="url" :value="__('Url from Vetmanager')"/>
                <x-input id="url" class="block mt-1 w-full" type="url" name="url" :value="old('url')" required/>
            </div>

            <!-- API Key from Vetmanager -->
            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="key" :value="__('Api-Key from Vetmanager')"/>
                <x-input id="key" class="block mt-1 w-full" type="text" name="key" minlength="4" :value="old('key')"
                         required/>
            </div>

            <div class="flex items-center justify-end mb-3 col-12 col-md-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="btn btn-primary">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>
