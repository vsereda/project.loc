@section('basket_content')
    @if(isset($basket_content) && count($basket_content))

        @foreach($basket_content as $basket_item)
            <div class="panel panel-default">
                <div class="panel-heading panel-primary">
                    {{ $basket_item->attributes->dishserving->dish->title }}
                    {{ $basket_item->attributes->dishserving->serving->title }}:
                    {{ $basket_item->quantity }} шт.
                    Стоимость: {{ $basket_item->getPriceSum() }} грн.
                </div>
                <div class="panel-heading panel-primary">
                    <form action="{{ route('items.destroy', $basket_item->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-default">
                            Убрать из корзины
                        </button>
                    </form>
                </div>

            </div>
        @endforeach
        <div class="btn-group ">
            <a class="btn btn-default" href="{{ route('orders.create') }}">
                Оформить заказ
            </a>
            <a class="btn btn-default" href="{{ route('products.index') }}">
                Вернуться в меню
            </a>
        </div>
    @endif
@endsection