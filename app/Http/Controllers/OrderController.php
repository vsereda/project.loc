<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use function PHPSTORM_META\type;
use KitchenTaskList;
use ExecutionDate;
use KitchenODS;
use KitchenDS;
use TotalCost;
use KitchenOrders;

class OrderController extends Controller
{
    const PAGINATE = 10;

    public function tasks()
    {
        if (Auth::user()->hasRole('kitchener')) {
            return view('kitchen.tasks')->with([
                'page_title' => 'Задания',
                'kitchenTaskList' => KitchenTaskList::get(),
                'kitchenTaskList1' => KitchenTaskList::get(1),
                'kitchenTaskList2' => KitchenTaskList::get(2),
                'kitchenTaskList3' => KitchenTaskList::get(3),
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Display listing of orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('kitchener|courier')) {
            $pageTitle = 'Заказы на сегодня';
            $view = 'kitchen.orders';
        } else {
            return redirect()->route('home');
        }
        return view($view)->with([
            'orders' => KitchenOrders::get(self::PAGINATE),
            'page_title' => $pageTitle,
        ]);
    }

    /**
     * Show the form for creating a new order.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateOrderRequest $request)
    {
        $dsString = KitchenDS::dsString($request);
        if (count($dsString->keys()) && !($dishservings = KitchenDS::get($dsString->keys()))->contains(null)) {
            $total = TotalCost::get(KitchenDS::getCounts($dishservings, $dsString));
            return view('user.create_order')->with([
                'page_title' => 'Оформление заказа: итого ' . $total . 'грн.',
                'total' => $total,
                'dishServingCounts' => KitchenDS::getCounts($dishservings, $dsString),
                'executionDate' => ExecutionDate::get(),
            ]);
        }
        return redirect()->back()->withError('Ошибка. Заказ пустой');
    }

    /**
     * Store a newly created order in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfirmOrderRequest $request)
    {
        $order = Order::create([
//            'address_id' => Auth::user()->addresses->first()->id,
            'user_id' => Auth::user()->id,
            'dinner_time' => $request->dinner_time,
            'status' => 1,
            'execution' => ExecutionDate::get(),
        ]);
        KitchenODS::create($request, $order);
        return redirect()->route('products.index')->withStatus('Заказ создан');
    }
}