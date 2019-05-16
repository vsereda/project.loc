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
                            <div>
                                Приветствует Вас и предлагает <strong>доставку в офис</strong> наших <strong>элитных супов</strong>. Наши супы изготовлены из натуральных, экологически чистых продуктов и соответствуют марки «Органических продуктов». Многие из них относятся к классу вегетарианских.
                                При общем заказе в Ваш офис больше 10 изделий доставляются <strong>бесплатно</strong>.
                                Доставка осуществляется <strong>«на завтра»</strong> в соответствии  с Нашим меню в выбранное Вами время. Заказ «на завтра» должен быть оформлен до 22 часов текущего дня. Для этого необходимо <strong>зарегистрироваться и в дальнейшем использовать свой НИК..</strong>
                                Расчет осуществляется  на месте в наличной и безналичной форме. Для постоянных пользователей возможны варианты предоплаты.
                            </div>
                                <hr>
                            @foreach($dishes as $dish)
                                    <p>
                                        <strong>{{ $dish->title }}</strong>.<br>
                                @foreach($dish->servings as $serving)
                                    Порция {{ $serving->title }}: {{ $serving->pivot->price }} грн. &nbsp;&nbsp;&nbsp;

                                @endforeach
                                    </p>
                            @endforeach

                            @auth
                                <h4><a href="{{ route('products.index') }}">Оформить заказ</a></h4>
                            @endauth

                            @guest
                                <h4>Для возможности заказа <a href="{{ route('register') }}">зарегистируйтесь</a> или <a href="{{ route('login') }}">войдите под своим ником</a></h4>
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
