@extends('layouts.app')
@section('content')
    <div class="panel-body">
        @if(isset($orders))
            {{ $orders->links() }}
    </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead bgcolor="#f7f7f7">
                        <tr>
                            <th scope="col">
                                Время обеда
                            </th>
                            <th scope="col">
                                № Заказа
                            </th>
                            @role('courier')
                                <th scope="col">
                                    Сатус
                                </th>
                            @endrole
                            <th scope="col">
                                Заказчик
                            </th>
                            <th scope="col">
                                Адрес
                            </th>
                            <th scope="col">
                                Телефон
                            </th>
                            @role('courier')
                                <th scope="col">
                                    Стоимость
                                </th>
                            @endrole
                            <th scope="col">
                                Список супов
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($orders))
                            @foreach($orders as $order)
                                <tr
                                    @if($order->dinner_time == 1)
                                        bgcolor="#ffe6e6"
                                    @elseif($order->dinner_time == 2)
                                        bgcolor="#d7edff"
                                    @elseif($order->dinner_time == 3)
                                        bgcolor="#c9ffc0"
                                    @endif
                                >
                                    <th scope="row" rowspan="{{ $order->orderDishServings->count() }}">
                                        {{ $order->dinner_time }}
                                    </th>
                                    <td rowspan="{{ $order->orderDishServings->count() }}">
                                        @editable_order($order)
                                            <a href="{{ route('orders.edit', $order->id) }}"> {{ $order->id }} </a>
                                        @else
                                            {{ $order->id }}
                                        @endeditable_order
                                    </td>
                                    @role('courier')
                                        <td rowspan="{{ $order->orderDishServings->count() }}">
                                            @if($order->status == 1)
                                                не доставлен
                                            @endif
                                            @if($order->status == 2)
                                                реализован
                                            @endif
                                            @if($order->status == 3)
                                                клиент отсутствует
                                            @endif
                                            @if($order->status == 4)
                                                клиент отказался
                                            @endif
                                            @if($order->status == 5)
                                                нет связи с клиентом
                                            @endif
                                        </td>
                                    @endrole
                                    <td rowspan="{{ $order->orderDishServings->count() }}">
                                        {{ $order->user->name }}
                                    </td>
                                    <td rowspan="{{ $order->orderDishServings->count() }}">
                                        {{ $order->user->address->description }}
                                    </td>
                                    <td rowspan="{{ $order->orderDishServings->count() }}">
                                        <a href="tel:{{ '+38' . str_pad($order->user->phone, 10, '0', STR_PAD_LEFT) }}">
                                            +38{{ str_pad($order->user->phone, 10, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    @role('courier')
                                        <td rowspan="{{ $order->orderDishServings->count() }}">
                                            {{
                                                array_sum($order->orderDishServings->map(function ($item, $key) {
                                                    return  $item->dishServing->price * $item->count;
                                                })->toArray())
                                             }} грн.
                                        </td>
                                    @endrole
                                    @foreach($order->orderDishServings as $orderDishServing)
                                        <td
                                            @if($order->dinner_time == 1)
                                                bgcolor="#ffe6e6"
                                            @elseif($order->dinner_time == 2)
                                                bgcolor="#d7edff"
                                            @elseif($order->dinner_time == 3)
                                                bgcolor="#c9ffc0"
                                            @endif
                                        >
                                            {{ $orderDishServing->dishServing->dish->title  }}
                                            ({{ $orderDishServing->dishServing->serving->title }})
                                            -{{ $orderDishServing->count }}шт.
                                        </td>
                                </tr>
                                <tr>
                                    @endforeach
                                        </td>
                                    </tr>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                @role('kitchener')
                                    <td colspan="6">
                                        Нет заказов
                                    </td>
                                @endrole
                                @role('courier')
                                    <td colspan="8">
                                        Нет заказов
                                    </td>
                                @endrole
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
    <div class="panel-body">
    {{ $orders->links() }}
        @endif
    </div>
@endsection