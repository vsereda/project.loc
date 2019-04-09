{{-- if user belongs to the kitchen --}}

@include('products')
@include('basket_content')

@role('kitchener|user')
    @include('kitchen.order_edit')
    @include('kitchen.orders')
@endrole

@role('user')
    @include('user.orders')
@endrole

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @isset($page_title)
                            {{ $page_title }}
                        @else
                            Page title
                        @endisset
                    </div>

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


                        @yield('kitchen_orders')
                        @yield('kitchen_order_edit')
                        @yield('products')
                        @yield('basket_content')
                        @yield('order_content')


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
