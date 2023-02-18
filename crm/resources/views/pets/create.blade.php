<x-app-layout>
    <div class="container">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добавить Питомца') }}
        </h2>

        <form method="POST" action="{{ route('pet.store') }}">
            @csrf

            <input type="hidden" name="owner_id" value="{{ $ownerId }}">

            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="alias" :value="__('Кличка')"/>
                <x-input id="alias" class="block mt-1 w-full" type="text" name="alias" :value="old('alias')" required
                         autofocus/>
            </div>

            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="type_id" :value="__('Вид_id')"/>
                <x-input id="type_id" class="block mt-1 w-full" type="text" name="type_id" :value="old('type_id')"
                         required autofocus/>

            </div>

            <div class="row justify-content-center mb-3 col-12 col-md-4">
                <x-label for="breed_id" :value="__('Порода_id')"/>
                <x-input id="breed_id" class="block mt-1 w-full" type="text" name="breed_id" :value="old('breed_id')"
                         required autofocus/>

            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="btn btn-primary">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
