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

                    <form action="{{ route('orders.create') }}" method="post">
                        {{ csrf_field() }}

                    <div class="equal">
                        <div class="prod-header col-xs-12 p-l-xl border-bottom">
                            <h4><strong>Заказать доставку на {{ $executionDate }}. Выберите суп</strong></h4>
                        </div>
{{--                        @foreach($servings as $serving)--}}
{{--                            <div class="col-xs-6 p-t-lg border-bottom">--}}
{{--                                <p class="text-center">--}}
{{--                                    <strong>Порция {{ $serving->title }}</strong>--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
                        @foreach($dishes as $dish)
                            <div class="prod-dish col-xs-12  p-t-xl text-center">
                                <h4 >
                                    <strong>{{ $dish->title }}</strong>
                                </h4>
                            </div>
                            @foreach($servings as $serving)
                            <div class="col-xs-12 p-b-md col-sm-6 ">
                                <div class="prod-desc col-xs-12 p-b-xs text-center ">
                                    @if($dish->dishServings->where('serving_id', $serving->id)->first())
                                        <h4>порция {{ $serving->title }}</h4>
                                        <h4 class="help-block">
                                            {{ $dish->dishServings->where('serving_id', $serving->id)->first()->price }} грн. за порцию
                                        </h4>

                                    @endif
                                </div>

                                <div class="col-xs-12 p-b-xs  text-center ">
                                    <input type="number"
                                           class="input-lg"
                                           name="dish_servings[{{ $dish->id }}/{{ $serving->id }}]"
                                           id="dish_servings_{{ $dish->id }}/{{ $serving->id }}" step="1"
                                           min="0"
                                           placeholder="количество"
                                    >
                                </div>
                            </div>
                                <hr>

                            @endforeach
                            <hr>
                        @endforeach
                        <div class="form-group col-xs-12 p-l-xl p-t-xl p-b-xl p-r-xl text-center">
                            <button class="btn btn-info btn-lg">
                                Заказать
                            </button>
                        </div>




                    </form>

                @endif
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection