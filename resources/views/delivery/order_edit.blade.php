@extends('layouts.app')
@section('content')
    <div class="panel-body">
        @if(isset($order))
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <strong>
                        № Заказа
                    </strong>
                    {{ $order->id }}
                </li>
                <li>
                    <strong>
                        Время обеда
                    </strong>
                    {{ $order->dinner_time }}
                </li>
                <li>
                    <strong>
                        Заказчик
                    </strong>
                    {{ $order->user->name }}
                </li>
                <li>
                    <strong>
                        Адрес
                    </strong>
                    {{ $order->user->address->description }}
                </li>
                <li>
                    <strong>
                        Телефон:
                        <a href="tel:{{ $order->user->phone }}">
                            {{ $order->user->phone }}
                        </a>
                    </strong>
                </li>
                <li>
                    <strong>
                        Стоимость
                    </strong>
                    {{
                        array_sum($order->orderDishServings->map(function ($item, $key) {
                            return  $item->dishServing->price * $item->count;
                        })->toArray())
                    }} грн.
                </li>
                <li>
                    <strong>
                        Список супов:
                    </strong>
                    <ul>
                        @foreach($order->orderDishServings as $orderDishServing)
                            <li>
                                {{ $orderDishServing->dishServing->dish->title  }}
                                ({{ $orderDishServing->dishServing->serving->title }})
                                -{{ $orderDishServing->count }}шт.
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <strong>
                        Статус:
                    </strong>
                </li>
            </ul>
            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="radio">
                    <label>
                        <input type="radio" name="status" value="1"
                           @if($order->status == 1)
                               checked
                           @endif
                        >
                        &nbsp Не доставлен
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" value="2"
                           @if($order->status == 2)
                               checked
                           @endif
                        >
                        &nbsp Реализован</label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" value="3"
                           @if($order->status == 3)
                               checked
                           @endif
                        >
                        &nbsp Клиент отсутствует
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" value="4"
                           @if($order->status == 4)
                               checked
                           @endif
                        >
                        &nbsp Клиент отказался
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" value="5"
                               @if($order->status == 5)
                               checked
                                @endif
                        >
                        &nbsp Нет связи с клиентом
                    </label>
                </div>
                <div class="form-group p-t-lg">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-info btn-lg">
                            Сохранить
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection