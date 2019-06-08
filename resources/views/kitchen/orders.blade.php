@extends('layouts.app')
@section('content')
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead bgcolor="#f7f7f7">
                <tr>
                    <th scope="col">
                        Время обеда
                    </th>
                    <th scope="col">
                        Адрес
                    </th>
                    <th scope="col">
                        Список супов
                    </th>
                </tr>
            </thead>
            <tbody>
                @if(count($orders))
                    @foreach($orders as $key => $addressCollection)
                        <tr
                            @if($key == 1)
                                bgcolor="#ffe6e6"
                            @elseif($key == 2)
                                bgcolor="#d7edff"
                            @elseif($key == 3)
                                bgcolor="#c9ffc0"
                            @endif
                        >
                            <th rowspan="
                                {{ $addressCollection->map(function ($item, $key){
                                    return $item->count();
                                })->values()->sum() }}
                            ">
                                {{-- DINNER TIME --}}
                                {{ $key }}
                            </th>
                            @foreach($addressCollection as $address => $dishServingCollection)
                                @if($addressCollection[$address] != $addressCollection->first())
                                    <tr
                                        @if($key == 1)
                                            bgcolor="#ffe6e6"
                                        @elseif($key == 2)
                                            bgcolor="#d7edff"
                                        @elseif($key == 3)
                                            bgcolor="#c9ffc0"
                                        @endif
                                    >
                                @endif
                                <td rowspan="{{ $dishServingCollection->map(function ($item, $key){
                                            return $item->count();
                                        })->values()->sum() / 2 }}">
                                    {{-- ADDRESS--}}
                                    {{ $address }} - {{ $dishServingCollection->map(function ($item, $key){
                                                return $item->count();
                                            })->values()->sum() / 2 }}
                                </td>
                                @foreach($dishServingCollection as $dishServingKey => $dishServing)
                                    @if($dishServingCollection[$dishServingKey] != $dishServingCollection->first())
                                        <tr
                                            @if($key == 1)
                                                bgcolor="#ffe6e6"
                                            @elseif($key == 2)
                                                bgcolor="#d7edff"
                                            @elseif($key == 3)
                                                bgcolor="#c9ffc0"
                                            @endif
                                        >
                                    @endif
                                    <td>
                                        {{-- DISH SERVING --}}
                                        {{ $dishServing['dishServing']->dish->title }}
                                        {{ $dishServing['dishServing']->serving->title }}
                                        - {{ $dishServing['count'] }} шт.
                                    </td>
                                    </tr>
                                @endforeach
                            @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">
                            Нет заказов
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection