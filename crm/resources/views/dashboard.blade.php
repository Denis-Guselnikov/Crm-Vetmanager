<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Главная страница') }}
        </h2>
        <div><a href="{{ route('clients.create') }}" class="btn btn-outline-primary">Добавить клиента</a></div>
    </x-slot>

    {{--    Таблица START --}}
    <div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Телефон</th>
            <th>Почта</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
        <tr>
            <th scope="col">{{ $client['id'] }}</th>
            <th scope="col">{{ $client['first_name'] }}</th>
            <th scope="col">{{ $client['last_name'] }}</th>
            <th scope="col">{{ $client['home_phone'] }}</th>
            <th scope="col">{{ $client['email'] }}</th>
            <th>
            <a href="" class="btn btn-outline-danger">Удалить</a>
            <a href="" class="btn btn-outline-secondary">Обновить</a>
            <a href="" class="btn btn-outline-info">Инфо</a>
            </th>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    {{--    Таблица END --}}

</x-app-layout>
