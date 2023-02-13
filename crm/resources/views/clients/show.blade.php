<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Страница Пользователя') }}
        </h2>
    </x-slot>

    {{--    Таблица START --}}
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>Ключ</th>
                <th>Значение</th>
            </tr>
            </thead>
            <tbody>
            @foreach($client as $key =>$value)
                <tr>
                    <th scope="col">{{ $key }}</th>
                    <th scope="col">{{ json_encode($value, JSON_UNESCAPED_UNICODE) }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{--    Таблица END --}}

</x-app-layout>
