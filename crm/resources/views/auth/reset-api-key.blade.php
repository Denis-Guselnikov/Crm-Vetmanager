<x-guest-layout>

        <form method="POST" action="{{ route('reset-api-key') }}">
            @csrf

            <!-- Url -->
            <div class="mt-4">
                <x-label for="url" :value="__('Your URL')" />
                <x-input id="url" class="block mt-1 w-full" type="url" name="url" :value="old('url')" required  />
            </div>

            <!-- API Key -->
            <div class="mt-4">
                <x-label for="key" :value="__('API Key')" />
                <x-input id="key" class="block mt-1 w-full" type="text" name="key" minlength="4" :value="old('key')" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="btn btn-primary">
                    {{ __('Submit New Settings') }}
                </x-button>
            </div>
        </form>

</x-guest-layout>
