@section('kitchen_orders')
    @if(isset($kitchen_orders) && count($kitchen_orders) && count($kitchen_orders->first()->orderDishServings))
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">
                        № Заказа
                    </th>
{{--                    <th scope="col">--}}
{{--                        Создан--}}
{{--                    </th>--}}
                    <th scope="col">
                        Статус заказа
                    </th>
                    <th scope="col">
                        Время обеда
                    </th>
                    <th scope="col">
                        Стоимость
                    </th>
                    @role('kitchener')
                        <th scope="col">
                        </th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach($kitchen_orders as $order)
                    @if($order->status == 1)
                        <tr class="alert alert-danger">
                    @elseif($order->status == 2)
                        <tr class="alert alert-warning">
                    @elseif($order->status == 3)
                        <tr class="alert alert-info">
                    @elseif($order->status == 4)
                        <tr class="alert alert-success">
                    @else
                        <tr>
                    @endif
                        <th scope="row">
                            @editable_order($order)
                                <a href="{{ route('orders.edit', $order->id) }}">{{ $order->id }}</a>
                            @else
                                {{ $order->id }}
                            @endeditable_order
                        </th>
{{--                        <td>--}}
{{--                            {{ $order->created_at }}--}}
{{--                        </td>--}}
                        <td>
                            @if($order->status == 1)
                                Не приготовлен
                            @elseif ($order->status == 2)
                                Приготовлен
                            @elseif ($order->status == 3)
                                Доставляется
                            @elseif ($order->status == 4)
                                Получен клиентом
                            @endif

                        </td>
                        <td>
                            {{ $order->dinner_time }}
                        </td>
                        <td>{{
                            array_sum($order->orderDishServings->map(function ($item, $key) {
                                return  $item->dishServing->price * $item->count;
                            })->toArray())
                         }}</td>
                        <td>
                            @if(Auth::user()->hasRole('kitchener') )
                                @if(1 == $order->status)
                                    <form action="{{ route('orders.update',  $order->id ) }}"  method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <input type="hidden" name="status" value="2">
                                        @editable_order($order)
                                        <button type="submit" class="btn btn-default">Приготовлен</button>
                                        @else
                                            <button type="submit" class="btn btn-default" disabled>Приготовлен</button>
                                        @endeditable_order
                                    </form>
                                @elseif(2 == $order->status)
                                    <form action="{{ route('orders.update',  $order->id ) }}"  method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <input type="hidden" name="status" value="1">
                                        @editable_order($order)
                                            <button type="submit" class="btn btn-default">
                                                Не приготовлен
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-default" disabled>
                                                Не приготовлен
                                            </button>
                                        @endeditable_order
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </table>
        {{ $kitchen_orders->links() }}
    @endif
    @isset($kitchenTaskList)
        <table class="table">
            <caption><h4>Список что нужно приговтовить: </h4></caption>
            <thead>
            <tr>
                <th scope="col">
                    Название
                </th>
                    <th scope="col">
                        Всего
                    </th>
                <th scope="col">
                    Порция
                </th>
                <th scope="col">
                    Количество
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($kitchenTaskList as $dish => $dishCollection)
                <tr>
                    <th rowspan="{{ $dishCollection->count() }}">
                        {{ $dish }}
                    </th>
                    <td rowspan="{{ $dishCollection->count() }}">
                        {{
                            number_format($dishCollection->map(function ($item, $key){
                                return preg_replace("/[^0-9]/", '', $key) * $item;
                            })->sum(), 0, '`', ' ') . ' '. preg_replace("/[0-9]/", '', $dishCollection->keys()->first())
                        }}
                    </td>
                    @foreach($dishCollection as $key => $dishCount)
                        <td>
                            {{ $key }}
                        </td>
                        <td>
                            {{ $dishCount }}
                        </td>
                </tr>
                    @endforeach


            @endforeach

            </tbody>


        {{--                    <th scope="col">--}}
        {{--                        Создан--}}
        {{--                    </th>--}}

    @endisset
@endsection