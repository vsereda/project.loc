@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-body">

    @if(isset($orders))
        <div class="table-responsive">
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

                    <th scope="col">
                        Блюдо
                    </th>

                </tr>
            </thead>
            <tbody>
            @if(count($orders))
                @foreach($orders as $order)
                        <tr>

                        <th scope="row" rowspan="{{ $order->orderDishServings->count() }}">
                            {{ $order->dinner_time }}
                        </th>

                        <td rowspan="{{ $order->orderDishServings->count() }}">
                            @editable_order($order)

                                {{ $order->id }}
                            @else
                                {{ $order->id }}
                            @endeditable_order
                        </td>

                        <td rowspan="{{ $order->orderDishServings->count() }}">
                            {{ $order->user->name }}
                        </td>

                        <td rowspan="{{ $order->orderDishServings->count() }}">
                            {{ $order->user->address->description }}
                        </td>

                        <td rowspan="{{ $order->orderDishServings->count() }}">
                            <a href="tel:{{ '+38' . str_pad($order->user->phone, 10, '0', STR_PAD_LEFT) }}">+38{{ str_pad($order->user->phone, 10, '0', STR_PAD_LEFT) }}</a>
                        </td>

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
    </div>
        {{ $orders->links() }}
    @endif


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection