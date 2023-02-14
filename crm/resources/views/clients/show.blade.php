<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Страница клиента: ')}} {{ $client['first_name'] }}
        </h2>
    </x-slot>

    {{--    Таблица START --}}
    <div class="container">
        <div><a href="{{ route('pet.create', $client['id']) }}" class="btn btn-outline-primary">Добавить Питомца</a></div>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Телефон</th>
                <th>Почта</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <th>{{ $client['id'] }}</th>
                    <th>{{ $client['first_name'] }}</th>
                    <th>{{ $client['last_name'] }}</th>
                    <th>{{ $client['home_phone'] }}</th>
                    <th>{{ $client['email'] }}</th>
                </tr>
            </tbody>
        </table>
    </div>
    {{--    Таблица END --}}

</x-app-layout>
