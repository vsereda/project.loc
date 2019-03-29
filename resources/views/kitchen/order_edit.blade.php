@section('kitchen_order_edit')
    @if(isset($kitchen_order_edit))
        <form action="{{ route('orders.update', $kitchen_order_edit->id) }}" method="POST" name="edit_order">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            @foreach($kitchen_order_edit->orderDishServings as $ods)
                <div class="form-group">
                    <label>
                        {{ $ods->dishServing->dish->title
                        . ' (' . $ods->dishServing->serving->title
                        . '), количество: ' . $ods->count }} шт.
                        {{--<small>стоимость: {{ $ods->count * $ods->dishServing->price }} грн.</small>--}}
                    </label>
                </div>
            @endforeach

            <div class="form-group">
                <label>
                    Время обеда: {{ $kitchen_order_edit->dinner_time }}
                </label>
            </div>

            <div class="form-group">
                <label>
                    Адрес: {{ $kitchen_order_edit->address->description}}
                </label>
            </div>

            <div class="form-group">
                <label>
                    Заказчик: {{ $kitchen_order_edit->address->user->name
                    . '. телефон: ' .  $kitchen_order_edit->address->user->name}}
                </label>
            </div>

            <div class="form-group">
                <label>
                    Общая стоимость заказа: {{
                            array_sum($kitchen_order_edit->orderDishServings->map(function ($item, $key) {
                                return  $item->dishServing->price * $item->count;
                            })->toArray())
                     }} грн.
                </label>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="statusRadios1" value="1"
                        @if($kitchen_order_edit->status == 1)
                            checked
                        @endif
                    >
                    <label class="form-check-label" for="statusRadios1">
                        Заказ не приготовлен
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="statusRadios2" value="2"
                        @if($kitchen_order_edit->status == 2)
                            checked
                        @endif
                    >
                    <label class="form-check-label" for="statusRadios2">
                        Заказ приготовлен
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <button type="button" class="btn btn-primary" onclick="location.href='{{ route('orders.index') }}'">К списку заказов</button>
            </div>
        </form>
    @endif
@endsection