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
                        <button type="submit">
                            Удалить
                        </button>
                    </form>
                </div>

            </div>
        @endforeach
        <button type="button" onclick="location.href='{{ route('orders.create') }}'">
            Оформить заказ
        </button>
        <button type="button" onclick="location.href='{{ route('products.index') }}'">
            Назад в меню
        </button>
    @endif
@endsection