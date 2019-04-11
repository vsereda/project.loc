@role('superadministrator')
{{--<li>--}}
{{--    <a href="#">--}}
{{--        Суперадминистратор--}}
{{--    </a>--}}
{{--</li>--}}
@endrole
@role('administrator')
{{--<li>--}}
{{--    <a href="#">--}}
{{--        Администратор--}}
{{--    </a>--}}
{{--</li >--}}
@endrole
@role('kitchener')
<li>
    <a href="{{ route('order.tasks') }}">
        Задания
    </a>
</li >
@endrole
@role('courier')
{{--<li>--}}
{{--    <a href="#">--}}
{{--        Доставка--}}
{{--    </a>--}}
{{--</li>--}}
@endrole

@role('user|kitchener')
<li>
    <a href="{{ route('orders.index') }}">
        Заказы
    </a>
</li>
@endrole
@role('user')
<li>
    <a href="{{ route('products.index') }}">
        Меню
    </a>
</li>
@endrole
