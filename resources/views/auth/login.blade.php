@extends('layouts.app')
@section('content')
    <div class="panel-heading text-center">
        <h4>
            Вход сотрудника
        </h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal fs-18" method="POST" action="{{ route('kitchen_login') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                <label for="login" class="col-md-4 control-label">Логин</label>
                <div class="col-md-6">
                    <input
                        id="text"
                        type="login"
                        class="form-control"
                        name="login"
                        value="{{ old('login') }}"
                        required autofocus
                    >
                    @if ($errors->has('login'))
                        <span class="help-block">
                            <strong>{{ $errors->first('login') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Пароль</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input
                                type="checkbox"
                                name="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <span class="fs-18 fw-bold pl-4">
                                Запомнить меня
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group p-t-lg">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-info btn-lg">
                        Вход
                    </button>
{{--                                <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                    Забыли пароль?--}}
{{--                                </a>--}}
                    <a class="btn btn-info btn-lg ml-05" href="{{ route('register') }}">
                        Регистрация
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection