<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDishServing;
use App\User;
use Carbon\Carbon;
use Darryldecode\Cart\CartCollection;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class OrderController extends Controller
{
    const PAGINATE = 10;

    public function __construct()
    {
        if (!Auth::user()) {
            session(['order_back_url' => URL::current()]);
        }
        $this->middleware('auth');
    }

    /**
     * Display listing of orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session()->forget('order_edit_back_url');
        if (Auth::user()->hasRole('user')) {
            $kitchenTaskList = null;
            $ordersPaginated = $this->getUserOrders(self::PAGINATE, Auth::user());
            $pageTitle = 'Заказы';
        } elseif (Auth::user()->hasRole('kitchener')) {
            $kitchenTaskList = $this->getKitchenTaskList();



//            dd($kitchenTaskList);



            $ordersPaginated = $this->getKitchenerOrders(self::PAGINATE);
            $pageTitle = ($this->getDeadlineTime() > Carbon::now())
                ? 'Заказы еще могут быть изменены или удалены клиентом'
                : 'Не готовые заказы зафиксированы и подлежат выполнению';
        }

        return view('home')->with([
            'kitchen_orders' => $ordersPaginated,
            'page_title' => $pageTitle,
            'basket' => Cart::getTotalQuantity(),
            'kitchenTaskList' => $kitchenTaskList,
        ]);
    }

    /**
     * Show the form for creating a new order.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session()->forget('order_edit_back_url');
        if (Auth::user()->hasRole('user')) {
            $addresses = Auth::user()->addresses;
            if (!count($addresses)) {
                session(['order_back_url' => URL::current()]);
            }
            return view('home')->with([
                'cart_for_order' => Cart::getContent(),
                'user_addresses' => $addresses,
                'page_title' => 'Оформление заказа: итого ' . Cart::getTotal() . 'грн.',
            ]);
        }
    }

    /**
     * Store a newly created order in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->hasRole('user') && Cart::getTotalQuantity()) {
            $order = Order::create([
                'address_id' => $request->address_id,
                'dinner_time' => $request->dinner_time,
                'status' => 1,
            ]);
//CartCollection
            $this->createOrderDishservings(Cart::getContent(), $order);

//            foreach (Cart::getContent() as $item) {
//                OrderDishServing::create([
//                    'order_id' => $order->id,
//                    'dish_id' => $item->attributes->dishserving->dish_id,
//                    'serving_id' => $item->attributes->dishserving->serving_id,
//                    'count' => $item->quantity,
//                ]);
//            };

            Cart::clear();
            Cart::session(Auth::user()->id)->clear();

            return redirect()->route('products.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session(['order_edit_back_url' => url()->previous()]);

        if (Auth::user()->hasRole('user') && ($order = $this->getUserEditOrder($id))) {
            return $this->returnEditView($order, $id, Cart::getTotalQuantity());
        } elseif (Auth::user()->hasRole('kitchener') && ($order = $this->getKitchenerEditOrder($id))) {
            return $this->returnEditView($order, $id, Cart::getTotalQuantity());
        }
        return redirect()->route('orders.index')->withError('Заказ №' . $id . ' не может быть изменен.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($client = Auth::user()->hasRole('user')) {
            $order = $this->getUserEditOrder($id);
            return ($order && $this->orderUpdate($order, $request, $client))
                ? redirect($this->updateBackURI())->withStatus('Заказ №' . $id . ' сохранен.')
                : redirect($this->updateBackURI())->withError('Запрещено.');

        } elseif (Auth::user()->hasRole('kitchener')) {
            $client = false;
            $order = ($this->getDeadlineTime() < Carbon::now()) ? $this->getKitchenerEditOrder($id) : null;
            return ($order && $this->orderUpdate($order, $request, $client))
                ? redirect($this->updateBackURI())->withStatus('Заказ №' . $id . ' сохранен.')
                : redirect($this->updateBackURI())->withError('Запрещено.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        session()->forget('order_edit_back_url');
        if (Auth::user()->hasRole('user') && $order = $this->getUserEditOrder($id)) {
            $order->orderDishServings->map(function ($item) {
                $item->delete();
            });
            $order->delete();
            return redirect($this->updateBackURI())->withStatus('Заказ №' . $id . ' удален.');
        }
        return redirect($this->updateBackURI())->withError('Ошибка удаления заказа.');
    }


    // Protected functions

    protected function getDeadlineTime(): Carbon
    {
        return Carbon::today()->addHours(config('deadline.deadline'));
    }

    protected function getComparisonOperator(): string
    {
        if (Auth::user()->hasRole('user')) {
            return ($this->getDeadlineTime() > Carbon::now()) ? '<' : '>=';
        } elseif (Auth::user()->hasRole('kitchener')) {
            return '<';
        }
    }

    protected function getAvailableStatuses(): array
    {
        if (Auth::user()->hasRole('user')) {
            return [1];
        } elseif (Auth::user()->hasRole('kitchener')) {
            return [1, 2];
        }
        return [];
    }

    protected function returnEditView(Order $order, int $id, int $quantity): ?View
    {
        return view('home')->with([
            'order_edit' => $order,
            'page_title' => 'Заказ №' . $id,
            'basket' => $quantity,
        ]);
    }

    protected function getUserAddresses(Authenticatable $user): array
    {
        return $user->addresses->map(function ($item) {
            return $item->id;
        })->toArray();
    }

    protected function getUserEditOrder(int $id): ?Order
    {
        return Order::where('id', $id)
            ->whereIn('address_id', $this->getUserAddresses(Auth::user()))
            ->whereIn('status', $this->getAvailableStatuses())
            ->where('created_at', $this->getComparisonOperator(), $this->getDeadlineTime())
            ->first();
    }

    protected function getUserOrders(int $paginate, Authenticatable $authUser): ?LengthAwarePaginator
    {
        return Order::whereIn('address_id', $this->getUserAddresses($authUser))
            ->orderBy('id', 'desc')
            ->paginate($paginate);
    }

    protected function getKitchenerEditOrder(int $id): ?Order
    {
        return Order::where('id', $id)
            ->whereIn('status', $this->getAvailableStatuses())
            ->where('created_at', $this->getComparisonOperator(), $this->getDeadlineTime())
            ->first();
    }

    protected function getKitchenerOrders(int $paginate): ?LengthAwarePaginator
    {
        return Order::where('created_at', $this->getComparisonOperator(), $this->getDeadlineTime())
            ->whereIn('status', $this->getAvailableStatuses())
            ->orderBy('status')
            ->orderBy('dinner_time')
            ->orderBy('id')
            ->paginate($paginate);
    }

    protected function updateBackURI(): string
    {
        return (session()->pull('order_edit_back_url') ?? url()->previous());
    }

    protected function orderUpdate(Order $order, Request $request, bool $client)
    {
        $dinnerTime = $client ? $request->dinner_time : $order->dinner_time;
        $status = $client ? 1 : $request->status;
        $addressId = $client ? $request->address_id : $order->address_id;

        $order->status = $status;
        $order->dinner_time = $dinnerTime;
        $order->address_id = $addressId;
        return $order->save();
    }

    protected function createOrderDishservings(CartCollection $cartContent, Order $order)
    {
        foreach ($cartContent as $item) {
            OrderDishServing::create([
                'order_id' => $order->id,
                'dish_id' => $item->attributes->dishserving->dish_id,
                'serving_id' => $item->attributes->dishserving->serving_id,
                'count' => $item->quantity,
            ]);
        };
    }

    protected function getNotMadeOrders()
    {
        return Order::where('created_at', $this->getComparisonOperator(), $this->getDeadlineTime())
            ->whereIn('status', [1])
            ->with(['orderDishServings'])
            ->get();
    }

    protected function getKitchenTaskList()
    {
        return $this->getNotMadeOrders()->map(function ($item) {
            return $item->orderDishServings;
        })
            ->collapse()
            ->groupBy(function ($item) {
                return $item->dishServing->dish->title;
            })
            ->map(function ($item) {
                return $item->groupBy(function ($item) {
                    return $item->dishServing->serving->title;
                })->map(function ($item) {
                    $res3 = $item;
                    return $res3->sum('count');
                });
            });
    }
}