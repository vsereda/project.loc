@extends('layouts.app')
@section('content')
    <div class="panel-body">
        @isset($kitchenTaskList1)
            <task-list
                task-list="{{ json_encode($kitchenTaskList1, JSON_UNESCAPED_UNICODE) }}"
                title="Приговтовить к 1-му обеду:"
            >
            </task-list>
        @endisset
        @isset($kitchenTaskList2)
            <task-list
                    task-list="{{ json_encode($kitchenTaskList2, JSON_UNESCAPED_UNICODE) }}"
                    title="Приговтовить ко 2-му обеду:"
            >
            </task-list>
        @endisset
        @isset($kitchenTaskList3)
            <task-list
                task-list="{{ json_encode($kitchenTaskList3, JSON_UNESCAPED_UNICODE) }}"
                title="Приговтовить к 3-му обеду:"
            >
            </task-list>
        @endisset
        @isset($kitchenTaskList)
            <task-list
                task-list="{{ json_encode($kitchenTaskList, JSON_UNESCAPED_UNICODE) }}"
                title="Приговтовить на весь день:"
            >
            </task-list>
        @endisset
    </div>
@endsection