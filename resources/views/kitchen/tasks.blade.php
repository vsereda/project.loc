@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">

    @isset($kitchenTaskList1)
        <table class="table table-bordered">
            <caption>
                <h4>
                    Приговтовить к 1-му обеду:
                </h4>
            </caption>
            <thead>
                <tr>
                    <th scope="col">
                        Название
                    </th>
                    <th scope="col">
                        Всего
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach($kitchenTaskList1 as $dish => $dishCollection)
                <tr>
                    <th >
                        {{ $dish }}
                    </th>
                    <td >
                        {{
                            number_format($dishCollection->map(function ($item, $key){
                                return preg_replace("/[^0-9]/", '', $key) * $item;
                            })->sum(), 0, '\'', ' ') . ' '. preg_replace("/[0-9]/", '', $dishCollection->keys()->first())
                        }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset

    @isset($kitchenTaskList2)
        <table class="table table-bordered">
            <caption>
                <h4>
                    Приговтовить ко 2-му обеду:
                </h4>
            </caption>
            <thead>
            <tr>
                <th scope="col">
                    Название
                </th>
                <th scope="col">
                    Всего
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($kitchenTaskList2 as $dish => $dishCollection)
                <tr>
                    <th >
                        {{ $dish }}
                    </th>
                    <td >
                        {{
                            number_format($dishCollection->map(function ($item, $key){
                                return preg_replace("/[^0-9]/", '', $key) * $item;
                            })->sum(), 0, '\'', ' ') . ' '. preg_replace("/[0-9]/", '', $dishCollection->keys()->first())
                        }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset

    @isset($kitchenTaskList3)
        <table class="table table-bordered">
            <caption>
                <h4>
                    Приговтовить к 3-му обеду:
                </h4>
            </caption>
            <thead>
            <tr>
                <th scope="col">
                    Название
                </th>
                <th scope="col">
                    Всего
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($kitchenTaskList3 as $dish => $dishCollection)
                <tr>
                    <th >
                        {{ $dish }}
                    </th>
                    <td >
                        {{
                            number_format($dishCollection->map(function ($item, $key){
                                return preg_replace("/[^0-9]/", '', $key) * $item;
                            })->sum(), 0, '\'', ' ') . ' '. preg_replace("/[0-9]/", '', $dishCollection->keys()->first())
                        }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset

    @isset($kitchenTaskList)
        <table class="table table-bordered">
            <caption>
                <h4>
                    Приговтовить на весь день:
                </h4>
            </caption>
            <thead>
            <tr>
                <th scope="col">
                    Название
                </th>
                <th scope="col">
                    Всего
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($kitchenTaskList as $dish => $dishCollection)
                <tr>
                    <th >
                        {{ $dish }}
                    </th>
                    <td >
                        {{
                            number_format($dishCollection->map(function ($item, $key){
                                return preg_replace("/[^0-9]/", '', $key) * $item;
                            })->sum(), 0, '\'', ' ') . ' '. preg_replace("/[0-9]/", '', $dishCollection->keys()->first())
                        }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset
                    </div>
                    </div>
                </div>
            </div>
        </div>

@endsection