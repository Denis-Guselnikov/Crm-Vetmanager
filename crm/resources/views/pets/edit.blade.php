<x-app-layout>

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Редактировать Питомца') }}
    </h2>

    <form method="POST" action="{{ route('pet.update', $id) }}">
        @csrf
        {{ method_field('PUT') }}

        <div>
            <x-label for="alias" :value="__('alias')" />
            <x-input id="alias" class="block mt-1 w-full" type="text" name="alias" :value="old('alias')" required autofocus />
        </div>

        <div>
            <x-label for="type_id" :value="__('type_id')" />
            <x-input id="type_id" class="block mt-1 w-full" type="text" name="type_id" :value="old('type_id')" required autofocus />

        </div>

        <div>
            <x-label for="breed_id" :value="__('breed_id')" />
            <x-input id="breed_id" class="block mt-1 w-full" type="text" name="breed_id" :value="old('breed_id')" required autofocus />

        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button class="btn btn-primary">
                {{ __('Submit') }}
            </x-button>
        </div>

    </form>
</x-app-layout>
