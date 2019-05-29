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
    <a href="{{ route('orders.tasks') }}">
        Приготовить
    </a>
</li >
@endrole
@role('courier')
<li>
    <a href="{{ route('delivery.index') }}">
        Оповещения
    </a>
</li>
@endrole
@role('kitchener|courier')
<li>
    <a href="{{ route('orders.kitchen') }}">
        По адресам
    </a>
</li>
<li>
    <a href="{{ route('orders.delivery') }}">
        По заказам
    </a>
</li>
@endrole