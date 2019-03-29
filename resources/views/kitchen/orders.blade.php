@section('kitchen_orders')
    @if(isset($kitchen_orders) && count($kitchen_orders) && count($kitchen_orders->first()->orderDishServings))
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">
                        № Заказа
                    </th>
                    <th scope="col">
                        Создан
                    </th>
                    <th scope="col">
                        Статус заказа
                    </th>
                    <th scope="col">
                        Время обеда
                    </th>
                    <th scope="col">
                        Стоимость
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($kitchen_orders as $order)
                    @if($order->status == 1)
                        <tr class="alert alert-danger">
                    @elseif($order->status == 2)
                        <tr class="alert alert-success">
                    @else
                        <tr>
                    @endif
                        <th scope="row">
                            <a href="{{ route('orders.edit', $order->id) }}">
                                {{ $order->id }}
                            </a>
                        </th>
                        <td>
                            {{ $order->created_at }}
                        </td>
                        <td>
                            @if($order->status == 1)
                                Не приготовлен
                            @elseif ($order->status == 2)
                                Приготовлен
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
                    </tr>
                @endforeach
            </tbody>
    </table>
        {{ $kitchen_orders->links() }}
    @endif
@endsection