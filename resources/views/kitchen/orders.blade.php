@section('dashboard_content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">№ Заказа</th>
                <th scope="col">Блюдо</th>
                <th scope="col">Порция</th>
                <th scope="col">Количество</th>
                <th scope="col">Адрес</th>
            </tr>
        </thead>
        <tbody>
        @if(isset($orders) && count($orders))
            @foreach($orders as $order)
                @foreach($order->orderDishServings as $ods)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $ods->dishServing->dish->title }}</td>
                        <td>{{ $ods->dishServing->serving->title }}</td>
                        <td>{{ $ods->count }}</td>
                        <td>{{ $order->address->description }}</td>
                    </tr>
                @endforeach
            @endforeach
        @endif
        </tbody>
    </table>
@endsection