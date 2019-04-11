@section('kitchen_order_edit')
    @if(isset($order_edit))
        <form action="{{ route('orders.update', $order_edit->id) }}" method="POST" id="edit_order">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            @foreach($order_edit->orderDishServings as $ods)
                <div class="form-group">
                    <label>
                        {{ $ods->dishServing->dish->title
                        . ' (' . $ods->dishServing->serving->title
                        . '), количество: ' . $ods->count }} шт.
                        {{--<small>стоимость: {{ $ods->count * $ods->dishServing->price }} грн.</small>--}}
                    </label>
                </div>
            @endforeach

            @role('kitchener')
                <div class="form-group">
                    <label>
                        Время доставки: {{ $order_edit->dinner_time }}
                    </label>
                </div>
            @endrole

            @role('user')
                <div class="form-group">
                    <label for="sel1">
                        Выбрать время доставки:
                    </label>
                    <select name="dinner_time" class="form-control" id="sel1">
                        <option value="1"
                            @if(1 == $order_edit->dinner_time)
                                selected
                            @endif
                        >
                            Первое время
                        </option>
                        <option value="2"
                            @if(2 == $order_edit->dinner_time)
                                selected
                            @endif
                        >
                            Второе время
                        </option>
                        <option value="3"
                            @if(3 == $order_edit->dinner_time)
                                selected
                            @endif
                        >
                            Третее время
                        </option>
                    </select>
                </div>
            @endrole

            @role('kitchener')
                <div class="form-group">
                    <label>
                        Адрес: {{ $order_edit->address->description}}
                    </label>
                </div>
            @endrole

            @role('user')
            <div class="form-group">
                <label for="sel1">
                    Выбрать адрес доставки:
                </label>
                <select name="address_id" class="form-control" id="sel1">
                    @foreach(Auth::user()->addresses as $address)
                        <option value="{{ $address->id }}"
                            @if($order_edit->address->id == $address->id)
                                selected
                            @endif
                        >
                            {{ $address->description }}
                        </option>
                    @endforeach

                </select>
            </div>
            @endrole

            <div class="form-group">
                <label>
                    Заказчик: {{ $order_edit->address->user->name
                    . '. телефон: +38' .  str_pad($order_edit->address->user->phone, 10, '0', STR_PAD_LEFT) }}
                </label>
            </div>

            <div class="form-group">
                <label>
                    Общая стоимость заказа: {{
                            array_sum($order_edit->orderDishServings->map(function ($item, $key) {
                                return  $item->dishServing->price * $item->count;
                            })->toArray())
                     }} грн.
                </label>
            </div>

            <div class="form-group">
                <label>
                    Заказ создан: {{ $order_edit->created_at }}
                </label>
            </div>

            @role('kitchener')
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusRadios1" value="1"
                            @if($order_edit->status == 1)
                                checked
                            @endif
                        >
                        <label class="form-check-label" for="statusRadios1">
                            Заказ не приготовлен
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusRadios2" value="2"
                            @if($order_edit->status == 2)
                                checked
                            @endif
                        >
                        <label class="form-check-label" for="statusRadios2">
                            Заказ приготовлен
                        </label>
                    </div>
                </div>
            @endrole

            <div class="form-group btn-group">
                <button type="submit" class="btn btn-default" form="edit_order">
                    Сохранить
                </button>
                <a class="btn btn-btn btn-default" href="{{ route('orders.index') }}">
                    К списку заказов
                </a>
                @role('user')
                    <button type="submit" class="btn btn-default" form="delete_order">
                        Удалить заказ
                    </button>
                @endrole
            </div>
        </form>
        <form action="{{ route('orders.destroy', $order_edit->id) }}" id="delete_order" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
        </form>
    @endif
@endsection