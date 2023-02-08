<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Главная страница') }}
        </h2>
    </x-slot>

    {{--    Таблица START --}}
    <div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Питомцы</th>
            <th>Город</th>
            <th>Адрес</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="col">Тест</th>
            <th scope="col">Тест</th>
            <th scope="col">Тест</th>
            <th scope="col">Тест</th>
        </tr>
        </tbody>
    </table>
    </div>
    {{--    Таблица END --}}

</x-app-layout>
