<x-app-layout>
    <div class="container">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактировать клиента') }}
        </h2>

        <form method="POST" action="/clients/{{ $infoClient['id'] }}">
            @csrf
            {{ method_field('PUT') }}

            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="first_name" :value="__('Имя')"/>
                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                         value="{{ $infoClient['first_name'] }}" required autofocus/>
            </div>

            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="last_name" :value="__('Фамилия')"/>
                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                         value="{{ $infoClient['last_name'] }}" required autofocus/>
            </div>

            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="home_phone" :value="__('Домашний Телефон')"/>
                <x-input id="home_phone" class="block mt-1 w-full" type="text" name="home_phone"
                         value="{{ $infoClient['home_phone'] }}" required autofocus/>
            </div>

            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="email" :value="__('Почта')"/>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                         value="{{ $infoClient['email'] }}" required/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="btn btn-primary">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
