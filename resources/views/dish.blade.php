@extends('layouts.app')
@section('content')
    <div class="panel-body">
        <h1 class="text-center">Суп {{ mb_strtolower($dish->title) }}
        @if($dish->seasonal)
            (сезонный)
        @endif
        </h1>
        <p> {{ $dish->description }} </p>
        <p><strong>Состав: </strong>{{ $dish->composition }} </p>
        <div class="btn-group pt-4">
            <a href="{{ url()->previous() }}" class="btn btn-link btn-lg">Вернуться назад</a>
        </div>
    </div>
@endsection