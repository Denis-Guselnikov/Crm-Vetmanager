<x-guest-layout>
    <div class="container">
        <h2 class="font-semibold text-gray-800 leading-tight">
            {{ __('Url или API-Key введены не правильно!!!') }}
        </h2>

        <form method="POST" action="{{ route('reset-api-key') }}">
            @csrf

            <!-- Url from Vetmanager -->
            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="url" :value="__('Url from Vetmanager')" />
                <x-input id="url" class="block mt-1 w-full" type="url" name="url" :value="old('url')" required  />
            </div>

            <!-- API Key from Vetmanager -->
            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="key" :value="__('Api-Key from Vetmanager')" />
                <x-input id="key" class="block mt-1 w-full" type="text" name="key" minlength="4" :value="old('key')" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="btn btn-primary">
                    {{ __('Submit New Settings') }}
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>
