@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                @if ( $errors->has('dish_servings'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('dish_servings') }}</strong>
                    </div>
                @endif
                @if(isset($dishes) && count($dishes) && isset($servings) && count($servings))
                    <div class="equal">
                            <div class="col-xs-4 col-sm-2" style="border: 1px solid blue">
                                <p>
                                    Шпинатный с нутом
                                </p>
                            </div>
                        <div class="col-xs-4 col-sm-5" style="border: 1px solid blue">
                            <plus-minus-component
                                    name="dish_servings"
                                    id="dish_servings"
                            >
                            </plus-minus-component>
                        </div>
                        <div class="col-xs-4 col-sm-5" style="border: 1px solid blue">
                            <plus-minus-component
                                    name="dish_servings"
                                    id="dish_servings"
                            >
                            </plus-minus-component>
                        </div>



                        <div class="prod-header col-xs-12 p-l-xl border-bottom text-center">
                            <h4>Заказать доставку на {{ $executionDate }}. Выберите суп</h4>
                        </div>
                        <form action="{{ route('orders.create') }}" method="post">
                            {{ csrf_field() }}

                            @foreach($dishes as $dish)
                                <strong>{{ $dish->title }}</strong>
                                @foreach($servings as $serving)
                                    <plus-minus-component
                                            name="dish_servings[{{ $dish->id }}/{{ $serving->id }}]"
                                            id="dish_servings_{{ $dish->id }}/{{ $serving->id }}"
                                    >
                                    </plus-minus-component>
                                @endforeach
                            @endforeach
                            <button type="submit">ok</button>
                        </form>
                    </div>
                @endif
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

