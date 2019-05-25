@extends('layouts.app')
@section('content')
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(isset($dishes) && count($dishes))
            <div class="ubuntu-ft">
                <p>
                    Приветствует Вас и предлагает <strong>доставку в офис</strong> наших <strong>элитных супов</strong>.
                    Наши супы изготовлены из натуральных, экологически чистых продуктов и соответствуют марки «Органических
                    продуктов». Многие из них относятся к классу вегетарианских. При общем заказе в Ваш офис больше 10
                    изделий доставляются <strong>бесплатно</strong>. Доставка осуществляется <strong>«на завтра»</strong> в
                    соответствии  с Нашим меню в выбранное Вами время. Заказ «на завтра» должен быть оформлен до 22 часов
                    текущего дня. Для этого необходимо <strong>зарегистрироваться и в дальнейшем использовать свой НИК..
                    </strong> Расчет осуществляется  на месте в наличной и безналичной форме. Для постоянных пользователей
                    возможны варианты предоплаты.
                </p>
            </div>
            <hr>
            @foreach($dishes as $dish)
                <p>
                    <a href="{{ route('dishes.show', $dish->id) }}">
                        <strong>
                            {{ $dish->title }}.
                            @if($dish->seasonal)
                                (сезонный)
                            @endif
                            <br>
                        </strong>
                    </a>
                    @foreach($dish->servings as $serving)
                        {{ $serving->title }} - {{ $serving->pivot->price }} грн. &nbsp;&nbsp;&nbsp;
                    @endforeach
                </p>
            @endforeach
            @auth
                <hr>
                <div class="p-b-xl">
                    <div class="btn-group pt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg mr-2">
                            Перейти к созданию заказа
                        </a>
                    </div>
                </div>
            @endauth
            @guest
                <hr>
                <p>Для возможности заказа зарегистируйтесь или войдите под своим ником</p>
                <div class="p-b-xl">
                    <div class="btn-group pt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg mr-2">
                            Зарегистирваться
                        </a>
                    </div>
                    <div class="btn-group pt-4">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            Войти
                        </a>
                    </div>
                </div>
            @endguest
        @endif
    </div>
@endsection