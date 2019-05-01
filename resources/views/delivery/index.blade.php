@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <h3>Отправить смс о доставке на адрес:</h3>
                    @if(isset($orders) && $orders->count())
                        @foreach($orders as $key => $collection)
                            <h4>Время доставки №{{ $key}}:</h4>
                            @foreach($collection as $address)
                                <div class="form-group">
                                    <form class="form-horizontal" method="POST" action="{{ route('delivery.store') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="dinner_time" value="{{ $key }}">
                                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            {{ $address->description }}
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        @endforeach
                    @else
                        <hr>
                        <h4>Нет не доставленных заказов</h4>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
