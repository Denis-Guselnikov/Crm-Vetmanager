<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Результат поиска') }}
        </h2>
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
            </tr>
            </thead>
            <tbody>
            @foreach($searchClient as $client)
                <tr>
                    <th scope="col">{{ $client['id'] }}</th>
                    <th scope="col">{{ $client['first_name'] }}</th>
                    <th scope="col">{{ $client['last_name'] }}</th>
                    <th scope="col">{{ $client['home_phone'] }}</th>
                    <th scope="col">{{ $client['email'] }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{--    Таблица END --}}

</x-app-layout>
