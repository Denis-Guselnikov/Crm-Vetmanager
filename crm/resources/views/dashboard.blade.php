<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Главная страница') }}
        </h2>

        <div class="row justify-content-center mb-3 col-12 col-md-4">
            <form method="GET" action="/search">
                <input type="text" id="query" name="query">
                <button type="submit" class="btn btn-outline-primary">Поиск</button>
            </form>
        </div>
    </x-slot>

    {{--    Таблица START --}}
    <div class="container">
        <div><a href="{{ route('clients.create') }}" class="btn btn-outline-primary">Добавить клиента</a></div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Фамилия</th>
                <th scope="col">Телефон</th>
                <th scope="col">Почта</th>
                <th class="col-1">Редактировать</th>
                <th class="col-1">Информация</th>
                <th class="col-1">Удалить</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <th>{{ $client['id'] }}</th>
                    <th>{{ $client['first_name'] }}</th>
                    <th>{{ $client['last_name'] }}</th>
                    <th>{{ $client['home_phone'] }}</th>
                    <th>{{ $client['email'] }}</th>
                    <th>
                        <a href="{{ route('clients.edit', $client['id']) }}" class="btn btn-outline-secondary">edit</a>
                    </th>
                    <th>
                        <a href="{{ route('clients.show', $client['id']) }}" class="btn btn-outline-info">info</a>
                    </th>
                    <th>
                        <form method="POST" action="{{ route('clients.destroy', $client['id']) }}">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-outline-danger">delete</button>
                        </form>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{--    Таблица END --}}

</x-app-layout>
