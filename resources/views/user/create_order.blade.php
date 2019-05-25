@extends('layouts.app')
@section('content')
    @if ( $errors->has('dish_servings'))
        <div class="alert alert-danger">
            <strong>{{ $errors->first('dish_servings') }}</strong>
        </div>
    @endif
    <div class="panel-body">
        @if(isset($total) && isset($executionDate) && isset($dishServingCounts) && count($dishServingCounts))
            <h4>
                Ваш заказ общей стоимостью {{ $total }} грн.:
            </h4>
            <h4>
                Дата доставки {{ $executionDate->format('Y-m-d') }}
            </h4>
            @foreach($dishServingCounts as $dishServingCount)
                <p class="text-success">
                    {{ $dishServingCount['ds']->dish->title }}
                    ({{ $dishServingCount['ds']->serving->title }})
                    -{{ $dishServingCount['count'] }} шт.
                </p>
            @endforeach
            <hr>
            <form action="{{ route('orders.store') }}" method="post">
                {{ csrf_field() }}
                @foreach($dishServingCounts as $key => $dishServingCount)
                    <input
                       type="hidden"
                       name="dish_servings[{{ $dishServingCount['ds']->dish_id }}/{{ $dishServingCount['ds']->serving_id }}]"
                       value="{{ $dishServingCount['count'] }}"
                    >
                @endforeach
                <div class="form-group">
                    @if ( $errors->has('dinner_time'))
                        <div class="alert alert-danger">
                            <strong>
                                {{ $errors->first('dinner_time') }}
                            </strong>
                        </div>
                    @endif
                    <label for="sel1">
                        Выберите время доставки и подтвердите заказ:
                    </label>
                    <select id="dinner_time" name="dinner_time" class="form-control" id="sel1">
                        <option value="1">
                            Первое время
                        </option>
                        <option value="2">
                            Второе время
                        </option>
                        <option value="3">
                            Третее время
                        </option>
                    </select>
                </div>
                <div class="p-b-xl">
                    <div class="btn-group pt-4">
                        <button type="submit" class="btn btn-info btn-lg mr-2">
                            Подтвердить заказ
                        </button>
                    </div>
                    <div class="btn-group pt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-info btn-lg">
                            Назад в меню
                        </a>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection