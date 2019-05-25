@extends('layouts.app')
@section('content')
    @if ( $errors->has('dish_servings'))
        <div class="alert alert-danger">
            <strong>{{ $errors->first('dish_servings') }}</strong>
        </div>
    @endif
    @if(isset($status))
        <div class="alert alert-success">
            <h2>
                {{ $status }}
            </h2>
        </div>
        <div class="panel-body text-center">
            <div class="text-center p-b-xl">
                <div class="btn-group pt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-info btn-lg mr-2" :disabled="counter == 0">
                        Вернутся к меню
                    </a>
                </div>
                <form id="logout-form2" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>
                <div class="btn-group pt-4">
                    <a href="{{ route('logout') }}"
                       class="btn btn-info btn-lg "
                       onclick="event.preventDefault();
                         document.getElementById('logout-form2').submit();">
                        Выйти
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection