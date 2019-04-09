@section('products')
    @if(isset($dishes) && count($dishes))
        @foreach($dishes as $dish)
            <div class="panel panel-default">
                <div class="panel-heading panel-primary">
                    <h3 class="panel-title">{{ $dish->title }}</h3>
                    <a href="{{ route('products.show', $dish->id) }}">
                        Заказать
                    </a>
                </div>
                <div class="panel-body">
                    {{ $dish->description }}
                </div>
            </div>
        @endforeach
    @endif
    @isset($dish_to_order)
        <form action="{{ route('items.store') }}" name="dish_to_basket" method="post" >
            {{ csrf_field() }}
            <input type="hidden" name="dish" value="{{ $dish_to_order->id }}">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                @foreach($dish_to_order->servings as $serving)
                    <label class="btn btn-secondary
                    @if($serving->id == 1)
                            active
                    @endif
                            ">
                        <input type="radio" name="serving" id="serving{{ $serving->id }}" autocomplete="off"
                               @if($serving->id == 1)
                               checked
                               @endif
                               value="{{ $serving->id }}"
                        >
                        {{ $serving->title }}
                        ({{ $serving->pivot->price }} грн.)
                    </label>
                @endforeach
            </div>
            <div class="form-group">
                <small class="form-text text-muted">Количество:</small>
                <input type="number" class="form-control " id="countInput" placeholder="Введите количество" name="count" required>
            </div>
            <button type="submit">
                Добавить в корзину
            </button>
            <button type="button" onclick="location.href='{{ route('items.index') }}'">
                Перейти в корзину
            </button>
        </form>
    @endisset
@endsection