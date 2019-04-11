@section('products')
    @if(isset($dishes) && count($dishes))
        @foreach($dishes as $dish)
            <div class="panel panel-default">
                <div class="panel-heading panel-primary">
                    <h2 class="panel-title">
                        <a href="{{ route('products.show', $dish->id) }}">
                            {{ $dish->title }}
                        </a>
                    </h2>
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
            <div class="btn-group btn-group-toggle col-xs-12" data-toggle="buttons">
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
            <div class="form-group col-xs-2">
                <small class="form-text text-muted">Количество:</small>
                <input type="number" class="form-control " id="countInput" placeholder="Введите количество" name="count" min="1" max="100" required value="1">
            </div>
            <div class="btn-group col-xs-12">
                <button type="submit" class="btn btn-default">
                    Добавить в корзину
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-default">
                    Назад
                </a>
                @if(Cart::getTotal())
                    <a href="{{ route('items.index') }}" class="btn btn-default">
                        Перейти в корзину
                    </a>
                @endif
            </div>
        </form>
    @endisset
@endsection