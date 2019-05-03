@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="row">
                <div class="col-xs-6 bg-primary">564</div>
                <div class="col-xs-6 bg-success">654</div>
            </div>
        </div>
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    @if ( $errors->has('dish_servings'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('dish_servings') }}</strong>
                        </div>
                    @endif

                        <div class="col-xs-6 bg-warning">hjfht</div>
                        <div class="col-xs-6 bg-success">hjfht</div>
                        <div class="row row-eq-heightgit">
                            <div class="col-xs-6 bg-warning">
                                <input type="number"
                                       name="dish_servings"
                                       id="dish_servings" step="1"
                                       min="0"
                                       placeholder="количество"
                                       size="55"
                                >
                            </div>
                            <div class="col-xs-6 bg-success">hjfht</div>
                        </div>
                        @if(isset($dishes) && count($dishes) && isset($servings) && count($servings))

                            <form action="{{ route('orders.create') }}" method="post">
                                {{ csrf_field() }}
                                <table class="table">
                                    <thead>
                                    <tr>
{{--                                        <th>Название</th>--}}
                                        @foreach($servings as $serving)
                                            <th>Порция {{ $serving->title }}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dishes as $dish)
                                        <tr>
{{--                                            <td>{{ $dish->title }}</td>--}}
                                            @foreach($servings as $serving)
                                                <td>
                                                    @if($dish->dishServings->where('serving_id', $serving->id)->first())
                                                        <span class="help-block">
                                                            {{ $dish->dishServings->where('serving_id', $serving->id)->first()->price }} грн. за порцию

                                                        </span>
                                                        <input type="number"
                                                               name="dish_servings[{{ $dish->id }}/{{ $serving->id }}]"
                                                               id="dish_servings_{{ $dish->id }}/{{ $serving->id }}" step="1"
                                                               min="0"
                                                               placeholder="количество"
                                                               size="55"
                                                        >
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <button class="btn btn-default">
                                        Заказать
                                    </button>
                                </div>
                            </form>
{{--                            <form action="{{ route('orders.create') }}" method="post">--}}
{{--                                {{ csrf_field() }}--}}
{{--                                @foreach($dishes as $dish)--}}
{{--                                    @foreach($dish->servings as $serving)--}}
{{--                                        <div class="form-group ">--}}
{{--                                            <label for="dish_servings_{{ $dish->id }}/{{ $serving->id }}">--}}
{{--                                                {{ $dish->title }}, порция {{ $serving->title }}--}}
{{--                                                -{{ $serving->pivot->price }} грн.--}}
{{--                                            </label>--}}

{{--                                            <input type="number"--}}
{{--                                                   name="dish_servings[{{ $dish->id }}/{{ $serving->id }}]"--}}
{{--                                                   id="dish_servings_{{ $dish->id }}/{{ $serving->id }}" step="1"--}}
{{--                                                   min="0">--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                @endforeach--}}

                                {{--                                <div class="form-group">--}}
                                {{--                                    <label for="sel1">--}}
                                {{--                                        Выбрать адрес доставки:--}}
                                {{--                                    </label>--}}
                                {{--                                    <select name="address_id" class="form-control" id="sel1">--}}
                                {{--                                        @foreach(Auth::user()->addresses as $address)--}}
                                {{--                                            <option value="{{ $address->id }}">{{ $address->description }}</option>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}

                                {{--                            <div class="form-group">--}}
                                {{--                                @if ( $errors->has('dinner_time'))--}}
                                {{--                                    <div class="alert alert-danger">--}}
                                {{--                                        <strong>{{ $errors->first('dinner_time') }}</strong>--}}
                                {{--                                    </div>--}}
                                {{--                                @endif--}}
                                {{--                                <label for="sel1">--}}
                                {{--                                    Выберите время доставки:--}}
                                {{--                                </label>--}}
                                {{--                                <select name="dinner_time" class="form-control" id="sel1">--}}
                                {{--                                    <option value="1">Первое время</option>--}}
                                {{--                                    <option value="2">Второе время</option>--}}
                                {{--                                    <option value="3">Третее время</option>--}}
                                {{--                                </select>--}}
                                {{--                            </div>--}}

{{--                                <div class="form-group">--}}
{{--                                    <button class="btn btn-default">--}}
{{--                                        Заказать--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{--@section('products')--}}
{{--    @if(isset($dishes) && count($dishes))--}}
{{--        <div class="p-t-30">--}}
{{--            <h4> В этом месте вставлям рекламу. </h4>--}}
{{--        </div>--}}
{{--            @foreach($dishes as $dish)--}}
{{--                @foreach($dish->servings as $serving)--}}
{{--                    <p>--}}
{{--                        {{ $dish->title }}, порция {{ $serving->title }} -{{ $serving->pivot->price }} грн.--}}
{{--                    </p>--}}
{{--                @endforeach--}}
{{--            @endforeach--}}

{{--        @auth--}}
{{--            <h4><a href="{{ route('orders.index') }}">Перейти в меню</a></h4>--}}
{{--        @endauth--}}

{{--        @guest--}}
{{--            <h4>Для возможности заказа <a href="{{ route('register') }}">зарегистируйтесь</a> или <a href="{{ route('login') }}">войдите</a></h4>--}}
{{--        @endguest--}}

{{--        @foreach($dishes as $dish)--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="panel-heading panel-primary">--}}
{{--                    <h2 class="panel-title">--}}
{{--                        <a href="{{ route('products.show', $dish->id) }}">--}}
{{--                            {{ $dish->title }}--}}
{{--                        </a>--}}
{{--                    </h2>--}}
{{--                </div>--}}
{{--                <div class="panel-body">--}}
{{--                    {{ $dish->description }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    @endif--}}

{{--    @isset($dish_to_order)--}}
{{--        <form action="{{ route('items.store') }}" name="dish_to_basket" method="post" >--}}
{{--            {{ csrf_field() }}--}}
{{--            <input type="hidden" name="dish" value="{{ $dish_to_order->id }}">--}}
{{--            <div class="btn-group btn-group-toggle col-xs-12" data-toggle="buttons">--}}
{{--                @foreach($dish_to_order->servings as $serving)--}}
{{--                    <label class="btn btn-secondary--}}
{{--                    @if($serving->id == 1)--}}
{{--                            active--}}
{{--                    @endif--}}
{{--                            ">--}}
{{--                        <input type="radio" name="serving" id="serving{{ $serving->id }}" autocomplete="off"--}}
{{--                               @if($serving->id == 1)--}}
{{--                               checked--}}
{{--                               @endif--}}
{{--                               value="{{ $serving->id }}"--}}
{{--                        >--}}
{{--                        {{ $serving->title }}--}}
{{--                        ({{ $serving->pivot->price }} грн.)--}}
{{--                    </label>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--            <div class="form-group col-xs-2">--}}
{{--                <small class="form-text text-muted">Количество:</small>--}}
{{--                <input type="number" class="form-control " id="countInput" placeholder="Введите количество" name="count" min="1" max="100" required value="1">--}}
{{--            </div>--}}
{{--            <div class="btn-group col-xs-12">--}}
{{--                <button type="submit" class="btn btn-default">--}}
{{--                    Добавить в корзину--}}
{{--                </button>--}}
{{--                <a href="{{ url()->previous() }}" class="btn btn-default">--}}
{{--                    Назад--}}
{{--                </a>--}}
{{--                @if(Cart::getTotal())--}}
{{--                    <a href="{{ route('items.index') }}" class="btn btn-default">--}}
{{--                        Перейти в корзину--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    @endisset--}}
{{--@endsection--}}
{{--<img class="product" src="https://d2lm6fxwu08ot6.cloudfront.net/img-thumbs/960w/IP3VG5E0X8.jpg" alt="food">--}}

