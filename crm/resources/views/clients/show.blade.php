<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Страница клиента: ')}} {{ $client['first_name'] }}
        </h2>
    </x-slot>

    {{-- Таблица Клиента START --}}
    <div class="container">
        <div><a href="{{ route('pets.create', $client['id']) }}" class="btn btn-outline-primary">Добавить Питомца</a>
        </div>
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
    {{-- Таблица Клиента END --}}

    {{-- Таблица Питомцев START --}}
    <div class="container">
        <h4 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Питомцы:')}}
        </h4>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Кличка</th>
                <th>Вид</th>
                <th>Порода</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pets as $pet)
                <tr>
                    <th>{{ $pet['id'] }}</th>
                    <th>{{ $pet['alias'] }}</th>
                    <th>{{ $pet['type']['title'] }}</th>
                    <th>{{ $pet['breed']['title'] }}</th>
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
    {{-- Таблица Питомцев END --}}
</x-app-layout>
