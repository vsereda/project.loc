@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    @if ( $errors->has('dish_servings'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('dish_servings') }}</strong>
                        </div>
                    @endif
                    @if(isset($dishes) && count($dishes) && isset($servings) && count($servings))
                        <form action="{{ route('orders.create') }}" method="post">
                            {{ csrf_field() }}
                            <div class="equal">

                                <div class="prod-header col-xs-12 text-center">
                                    <h4>Заказать доставку на {{ $executionDate }}. Выберите суп</h4>
                                </div>

                                <div class="col-xs-4 col-sm-2 border-bottom">
                                </div>

                                <div class="col-xs-4 col-sm-5 flex-center text-center border-bottom "
                                        {{--                                 style="border: 1px solid red"--}}
                                >
                                    <p>Малая порция</p>
                                </div>

                                <div class="col-xs-4 col-sm-5 flex-center text-center border-bottom "
                                        {{--                                 style="border: 1px solid red"--}}
                                >
                                    <p>Большая порция</p>
                                </div>

                                {{--                            foreach--}}
                                @foreach($dishes as $dish)
                                    <div class="col-xs-4 col-sm-2 flex-center text-center border-bottom">
                                        <p class="dish-child">
                                            {{ $dish->title }}
                                        </p>
                                    </div>
                                    @foreach($servings as $serving)
                                        <div class="p-l-r-0 col-xs-4 col-sm-5 border-bottom"
                                                {{--                                 style="border: 1px solid yellow"--}}
                                        >
                                            @if($dish->dishServings->where('serving_id', $serving->id)->first())
                                                {{--                                        <input type="number"--}}
                                                {{--                                               name="dish_servings[{{ $dish->id }}/{{ $serving->id }}]"--}}
                                                {{--                                               id="dish_servings_{{ $dish->id }}/{{ $serving->id }}" step="1"--}}
                                                {{--                                               min="0">--}}
                                                <plus-minus-component
                                                        name="dish_servings[{{ $dish->id }}/{{ $serving->id }}]"
                                                        id="dish_servings_{{ $dish->id }}/{{ $serving->id }}"
                                                        price="{{ $dish->dishServings->where('serving_id', $serving->id)->first()->price }}"
                                                >
                                                </plus-minus-component>
                                            @endif

                                        </div>
                                    @endforeach
                                    {{--                            <div class="p-l-r-0 col-xs-4 col-sm-5 border-bottom" >--}}
                                    {{--                                <plus-minus-component--}}
                                    {{--                                        name="dish_servings"--}}
                                    {{--                                        id="dish_servings"--}}
                                    {{--                                >--}}
                                    {{--                                </plus-minus-component>--}}
                                    {{--                            </div>--}}
                                    <hr>

                                @endforeach
{{--                            </div>--}}

                            {{--                            <form action="{{ route('orders.create') }}" method="post">--}}
                            {{--                                {{ csrf_field() }}--}}

                            {{--                                @foreach($dishes as $dish)--}}
                            {{--                                    <strong>{{ $dish->title }}</strong>--}}
                            {{--                                    @foreach($servings as $serving)--}}
                            {{--                                        <plus-minus-component--}}
                            {{--                                                name="dish_servings[{{ $dish->id }}/{{ $serving->id }}]"--}}
                            {{--                                                id="dish_servings_{{ $dish->id }}/{{ $serving->id }}"--}}
                            {{--                                        >--}}
                            {{--                                        </plus-minus-component>--}}
                            {{--                                    @endforeach--}}
                            {{--                                @endforeach--}}
                            <div class="form-group col-xs-12 p-l-xl p-t-xl p-b-xl p-r-xl text-center">
                                <button type="submit" class="btn btn-info btn-lg">
                                    Далее выберите время доставки
                                </button>
                            </div>
                            </div>
                        </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection

