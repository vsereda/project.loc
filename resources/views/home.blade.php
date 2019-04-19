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
            <div class="col-md-8 col-md-offset-2">
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
                                <h4> В этом месте вставлям рекламу. </h4>
                                <p>В конце рекламы список супов с порциями и ценами: </p>
                            </div>
                            @foreach($dishes as $dish)
                                @foreach($dish->servings as $serving)
                                    <p>
                                        {{ $dish->title }}, порция {{ $serving->title }} -{{ $serving->pivot->price }} грн.
                                    </p>
                                @endforeach
                            @endforeach

                            @auth
                                <h4><a href="{{ route('products.index') }}">Перейти к меню</a></h4>
                            @endauth

                            @guest
                                <h4>Для возможности заказа <a href="{{ route('register') }}">зарегистируйтесь</a> или <a href="{{ route('login') }}">войдите</a></h4>
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
