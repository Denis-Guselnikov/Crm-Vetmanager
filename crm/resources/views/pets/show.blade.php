<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Страница Питомца: ')}} {{ $pet['alias'] }}
        </h2>
        <div><a href="/clients/{{ $pet['owner_id'] }}">Вернуться к клиенту</a></div>
    </x-slot>

    {{-- Таблица Клиента START --}}
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pet as $key => $value)
            <tr>
                <th>{{ $key }}</th>
                <th>{{ json_encode($value, JSON_UNESCAPED_UNICODE) }}</th>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{-- Таблица Клиента END --}}
</x-app-layout>
