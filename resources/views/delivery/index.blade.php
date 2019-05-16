@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p class="alert alert-info">Количество оставшихся смс: <b>{{ $smsCount }}</b></p>
                    <h3>Отправить смс о доставке на адрес:</h3>
                    @if(isset($notices) && $notices->count())
                        @foreach($notices as $dinnerTime => $collectionNotices)
{{--                            {{ $key }} => <pre>{{ var_dump($collectionNotices['users']) }}</pre>--}}

{{--                            {{ $collectionNotices }}--}}
{{--                                <p>444444444444444444444</p>--}}
                                <h4>Время доставки №{{ $dinnerTime }}:</h4>
                            @foreach($collectionNotices['users'] as $key => $users)


{{--                                {{ $collectionNotices }}--}}

{{--                                @foreach($address as $address)--}}
                                    <div class="form-group">
                                        <form class="form-horizontal" method="POST" action="{{ route('delivery.store') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="dinner_time" value="{{ $dinnerTime }}">
                                            <input type="hidden" name="address_id" value="{{ $key }}">
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <small>
                                                    {{ $collectionNotices['addresses'][$key]->description }}
                                                </small><br>
                                                <small><strong>({{ $users->count() }} SMS)</strong></small>
                                            </button>
                                        </form>
                                    </div>
{{--                                @endforeach--}}
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
