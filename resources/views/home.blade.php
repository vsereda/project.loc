{{-- if user belongs to the kitchen --}}

{{--@include('products')--}}
{{--@include('basket_content')--}}

{{--@role('kitchener|user')--}}
{{--    @include('kitchen.order_edit')--}}
{{--    @include('kitchen.orders')--}}
{{--@endrole--}}

{{--@role('user')--}}
{{--    @include('user.orders')--}}
{{--@endrole--}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">

{{--                    <div class="panel-heading">--}}
{{--                        <h4>--}}
{{--                        @isset($page_title)--}}
{{--                            {{ $page_title }}--}}
{{--                        @else--}}
{{--                            Page title--}}
{{--                        @endisset--}}
{{--                        </h4>--}}
{{--                    </div>--}}

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


{{--                        @yield('kitchen_orders')--}}
{{--                        @yield('kitchen_order_edit')--}}
                        @if(isset($dishes) && count($dishes))
                            <div class="ubuntu-ft">
                                <p>
                                Приветствует Вас и предлагает <strong>доставку в офис</strong> наших <strong>элитных супов</strong>. Наши супы изготовлены из натуральных, экологически чистых продуктов и соответствуют марки «Органических продуктов». Многие из них относятся к классу вегетарианских.
                                При общем заказе в Ваш офис больше 10 изделий доставляются <strong>бесплатно</strong>.
                                Доставка осуществляется <strong>«на завтра»</strong> в соответствии  с Нашим меню в выбранное Вами время. Заказ «на завтра» должен быть оформлен до 22 часов текущего дня. Для этого необходимо <strong>зарегистрироваться и в дальнейшем использовать свой НИК..</strong>
                                Расчет осуществляется  на месте в наличной и безналичной форме. Для постоянных пользователей возможны варианты предоплаты.
                                </p>
                            </div>
                                <hr>
                            @foreach($dishes as $dish)
                                <p><a href="">
                                    <strong>
                                        {{ $dish->title }}.
                                        @if($dish->seasonal)
                                            (сезонный)
                                        @endif
                                        <br>
                                    </strong></a>
                                        @foreach($dish->servings as $serving)
                                            {{ $serving->title }} - {{ $serving->pivot->price }} грн. &nbsp;&nbsp;&nbsp;
                                        @endforeach

                                </p>
                            @endforeach

                            @auth
{{--                                <h4><a href="{{ route('products.index') }}">Оформить заказ</a></h4>--}}
                                    <hr>
                                    <div class="p-b-xl">
                                        <div class="btn-group pt-4">
                                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg mr-2">
                                                Оформить заказ
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
{{--                        @yield('basket_content')--}}
{{--                        @yield('order_content')--}}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
