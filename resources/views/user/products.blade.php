@extends('layouts.app')
@section('content')
    @if ( $errors->has('dish_servings'))
        <div class="alert alert-danger">
            <strong>
                {{ $errors->first('dish_servings') }}
            </strong>
        </div>
    @endif
    @if(isset($dishes) && count($dishes) && isset($servings) && count($servings))
        <form action="{{ route('orders.create') }}" method="post">
            {{ csrf_field() }}
            <div class="equal" >
                <div class="prod-header col-xs-12 text-center">
                    <h4>
                        Заказать доставку на {{ $executionDate }}. Выберите суп
                    </h4>
                </div>
                <div class="col-xs-4 col-sm-2 border-bottom"></div>
                <div class="col-xs-4 col-sm-5 flex-center text-center border-bottom ">
                    <p>
                        Малая порция
                    </p>
                </div>
                <div class="col-xs-4 col-sm-5 flex-center text-center border-bottom ">
                    <p>
                        Большая порция
                    </p>
                </div>
                @foreach($dishes as $dish)
                    <div class="col-xs-4 col-sm-2 flex-center text-center border-bottom">
                        <a class="dish-child" href="{{ route('dishes.show', $dish->id) }}">
                            {{ $dish->title }}
                        </a>
                    </div>
                    @foreach($servings as $serving)
                        <div class="p-l-r-0 col-xs-4 col-sm-5 border-bottom">
                            @if($dish->dishServings->where('serving_id', $serving->id)->first())
                                <plus-minus-component
                                    name="dish_servings[{{ $dish->id }}/{{ $serving->id }}]"
                                    id="dish_servings_{{ $dish->id }}/{{ $serving->id }}"
                                    price="{{ $dish->dishServings->where('serving_id', $serving->id)->first()->price }}"
                                >
                                </plus-minus-component>
                            @endif
                        </div>
                    @endforeach
                    <hr>
                @endforeach
                <div class="form-group col-xs-12 p-l-xl pt-5 p-b-xl p-r-xl text-center">
                    <counter></counter>
                </div>
            </div>
        </form>
    @endif
@endsection