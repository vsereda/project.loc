@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-body">
    @if(isset($orders))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">
                        Время обеда
                    </th>
                    <th scope="col">
                        № Заказа
                    </th>
                    <th scope="col">
                        Заказчик
                    </th>
                    <th scope="col">
                        Адрес
                    </th>
                    <th scope="col">
                        Телефон
                    </th>
{{--                    <th scope="col">--}}
{{--                        Создан--}}
{{--                    </th>--}}
{{--                    <th scope="col">--}}
{{--                        Статус заказа--}}
{{--                    </th>--}}

{{--                    <th scope="col">--}}
{{--                        Стоимость--}}
{{--                    </th>--}}
                    <th scope="col">
                        Блюдо
                    </th>
{{--                    @role('kitchener')--}}
{{--                        <th scope="col">--}}
{{--                        </th>--}}
{{--                    @endrole--}}
                </tr>
            </thead>
            <tbody>
            @if(count($orders))
                @foreach($orders as $order)
                        <tr>
{{--<tr>--}}
                        <th scope="row" rowspan="{{ $order->orderDishServings->count() }}">
                            {{ $order->dinner_time }}
                        </th>
{{--                        <td>--}}
{{--                            {{ $order->created_at }}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            @if($order->status == 1)--}}
{{--                                Не приготовлен--}}
{{--                            @elseif ($order->status == 2)--}}
{{--                                Приготовлен--}}
{{--                            @elseif ($order->status == 3)--}}
{{--                                Доставляется--}}
{{--                            @elseif ($order->status == 4)--}}
{{--                                Получен клиентом--}}
{{--                            @endif--}}

{{--                        </td>--}}
                        <td rowspan="{{ $order->orderDishServings->count() }}">
                            @editable_order($order)
{{--                            <a href="{{ route('orders.edit', $order->id) }}">{{ $order->id }}</a>--}}
                                {{ $order->id }}
                            @else
                                {{ $order->id }}
                            @endeditable_order
                        </td>

                        <td rowspan="{{ $order->orderDishServings->count() }}">
                            {{ $order->address->user->name }}
                        </td>

                        <td rowspan="{{ $order->orderDishServings->count() }}">
                            {{ $order->address->description }}
                        </td>

                        <td rowspan="{{ $order->orderDishServings->count() }}">
                            +38{{ str_pad($order->address->user->phone, 10, '0', STR_PAD_LEFT) }}
                        </td>


                            {{--                        <td>--}}
{{--                            {{--}}
{{--                            array_sum($order->orderDishServings->map(function ($item, $key) {--}}
{{--                                return  $item->dishServing->price * $item->count;--}}
{{--                            })->toArray())--}}
{{--                         }}--}}
{{--                        </td>--}}

{{--                        <td>--}}
{{--                            @if(Auth::user()->hasRole('kitchener') )--}}
{{--                                @if(1 == $order->status)--}}
{{--                                    <form action="{{ route('orders.update',  $order->id ) }}"  method="post">--}}
{{--                                        {{ csrf_field() }}--}}
{{--                                        {{ method_field('PUT') }}--}}
{{--                                        <input type="hidden" name="status" value="2">--}}
{{--                                        @editable_order($order)--}}
{{--                                        <button type="submit" class="btn btn-danger">Приготовлен</button>--}}
{{--                                        @else--}}
{{--                                            <button type="submit" class="btn btn-danger" disabled>Приготовлен</button>--}}
{{--                                        @endeditable_order--}}
{{--                                    </form>--}}
{{--                                @elseif(2 == $order->status)--}}
{{--                                    <form action="{{ route('orders.update',  $order->id ) }}"  method="post">--}}
{{--                                        {{ csrf_field() }}--}}
{{--                                        {{ method_field('PUT') }}--}}
{{--                                        <input type="hidden" name="status" value="1">--}}
{{--                                        @editable_order($order)--}}
{{--                                            <button type="submit" class="btn btn-default">--}}
{{--                                                Не приготовлен--}}
{{--                                            </button>--}}
{{--                                        @else--}}
{{--                                            <button type="submit" class="btn btn-default" disabled>--}}
{{--                                                Не приготовлен--}}
{{--                                            </button>--}}
{{--                                        @endeditable_order--}}
{{--                                    </form>--}}
{{--                                @endif--}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                            <td>--}}
                                @foreach($order->orderDishServings as $orderDishServing)
                                    <td>
                                        {{ $orderDishServing->dishServing->dish->title  }}
                                        ({{ $orderDishServing->dishServing->serving->title }})
                                        -{{ $orderDishServing->count }}шт.
                                    </td></tr>
                            <tr>
                                @endforeach
                            </td>
                        </tr>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">Нет заказов</td>
                </tr>
            @endif
            </tbody>
    </table>
        {{ $orders->links() }}
    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection