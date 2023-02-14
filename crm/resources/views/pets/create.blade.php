<x-app-layout>

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Pet For Owner') }}
        </h2>

        <form method="POST" action="{{ route('pet.store') }}">

            @csrf

            <input type="hidden" name="owner_id" value="{{ $ownerId }}">

            <div>
                <x-label for="alias" :value="__('nickname')" />
                <x-input id="alias" class="block mt-1 w-full" type="text" name="alias" :value="old('nickname')" required autofocus />
            </div>

            <div>
                <x-label for="type_id" :value="__('type_id')" />
                <x-input id="type_id" class="block mt-1 w-full" type="text" name="type_id" :value="old('type_id')" placeholder="6" required autofocus />

            </div>

            <div>
                <x-label for="breed_id" :value="__('breed_id')" />
                <x-input id="breed_id" class="block mt-1 w-full" type="text" name="breed_id" :value="old('breed_id')" placeholder="384" required autofocus />

            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Submit') }}
                </x-button>
            </div>

        </form>
</x-app-layout>
