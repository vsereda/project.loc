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
<li>
    <a href="{{ route('delivery.index') }}">
        Доставка
    </a>
</li>
@endrole
@role('kitchener|courier')
<li>
    <a href="{{ route('orders.index') }}">
        Заказы
    </a>
</li>
@endrole