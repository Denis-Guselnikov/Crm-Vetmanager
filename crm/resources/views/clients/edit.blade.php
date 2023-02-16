<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Редактировать клиента') }}
    </h2>

    <form method="POST" action="/clients/{{ $id }}">
        @csrf
        {{ method_field('PUT') }}

        <div class="mt-2">
            <x-label for="first_name" :value="__('first_name')" />
            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
        </div>

        <div class="mt-2">
            <x-label for="last_name" :value="__('last_name')" />
            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
        </div>

        <div class="mt-2">
            <x-label for="home_phone" :value="__('home_phone')" />
            <x-input id="home_phone" class="block mt-1 w-full" type="text" name="home_phone" :value="old('home_phone')" required autofocus />
        </div>

        <div class="mt-2">
            <x-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button class="btn btn-primary">
                {{ __('Submit') }}
            </x-button>
        </div>
    </form>
</x-app-layout>
