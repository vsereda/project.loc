@extends('layouts.app')
@section('content')
    <div class="alert alert-info">
        <p>
            Количество оставшихся смс: <b>{{ $smsCount }}</b>
        </p>
    </div>
    <div class="panel-body">
        <h3 class="fw-bold">
            Отправка смс о доставке по адресам:
        </h3>
        <hr>
        @if(isset($notices) && $notices->count())
            @foreach($notices as $dinnerTime => $collectionNotices)
                <h4>Время доставки №{{ $dinnerTime }}:</h4>
                @foreach($collectionNotices['users'] as $key => $users)
                    <div class="form-group">
                        <form class="form-horizontal" method="POST" action="{{ route('delivery.store') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="dinner_time" value="{{ $dinnerTime }}">
                            <input type="hidden" name="address_id" value="{{ $key }}">
                            <button type="submit" class="btn btn-success btn-lg m-b-md">
                                <small>
                                    {{ $collectionNotices['addresses'][$key]->description }}
                                </small>
                                <br>
                                <small>
                                    <strong>
                                        ({{ $users->count() }} SMS)
                                    </strong>
                                </small>
                            </button>
                        </form>
                    </div>
                @endforeach
            @endforeach
        @else
            <hr>
            <h4>
                Нет не доставленных заказов
            </h4>
        @endif
    </div>
@endsection