@section('order_content')
    @if(isset($cart_for_order) && count($cart_for_order) && isset($user_addresses) && count($user_addresses))

        @foreach($cart_for_order as $cart)
            <p>
                {{ $cart->attributes->dishserving->dish->title }}
                {{ $cart->attributes->dishserving->serving->title }}:
                {{ $cart->quantity }}шт.
                -{{ $cart->getPriceSum() }}грн.
            </p>
        @endforeach

        <form action="{{ route('orders.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="sel1">
                    Выбрать адрес доставки:
                </label>
                <select name="address_id" class="form-control" id="sel1">
                    @foreach($user_addresses as $address)
                        <option value="{{ $address->id }}">{{ $address->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sel1">
                    Выбрать время доставки:
                </label>
                <select name="dinner_time" class="form-control" id="sel1">
                    <option value="1">Первое время</option>
                    <option value="2">Второе время</option>
                    <option value="3">Третее время</option>
                </select>
            </div>
            <div class="btn-group ">
                <button type="submit" class="btn btn-default">
                    Заказать
                </button>
                <a href="{{ route('items.index') }}" class="btn btn-default">
                    Назад в корзину
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-default">
                     В меню
                </a>
            </div>
        </form>
    @elseif(isset($user_addresses) && !count($user_addresses))
        <form action="{{ route('addresses.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="InputAddress">Адрес доставки</label>
                <input type=text class="form-control" id="InputAddress" name="address" placeholder="Введите адрес..." required>
                <small id="emailHelp" class="form-text text-muted">Для того чтобы осуществлять покупки, пользователь должен иметь хотябы один адрес доставки.</small>
            </div>
            <button type="submit" class="btn btn-primary">Добавить адрес</button>
        </form>
    @endif
@endsection