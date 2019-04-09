<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDishServing;
use App\User;
use Carbon\Carbon;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
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
        if (Auth::user()->hasRole('user')) {
            $orders = Order::whereIn('address_id', $this->getUserAddresses(Auth::user()))
                ->orderBy('id', 'desc')
                ->paginate(self::PAGINATE);

        } elseif (Auth::user()->hasRole('kitchener')) {
            $orders = Order::where('created_at', $this->getComparisonOperator(), $this->getDeadlineTime())
                ->whereIn('status', $this->getAvailableStatuses())
                ->orderBy('status')
                ->orderBy('dinner_time')
                ->orderBy('id')
                ->paginate(self::PAGINATE);
        }

        return view('home')->with([
            'kitchen_orders' => $orders,
            'page_title' => 'Заказы',
            'basket' => Cart::getTotalQuantity(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasRole('user')) {
            $addresses = Auth::user()->addresses;
            if (!count($addresses)) {
                session(['order_back_url' => URL::current()]);
            }
            return view('home')->with([
                'cart_for_order' => Cart::getContent(),
                'user_addresses' => $addresses,
                'page_title' => 'Оформление заказа: всего ' . Cart::getTotal() . 'грн.',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
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

            foreach (Cart::getContent() as $item) {
                OrderDishServing::create([
                    'order_id' => $order->id,
                    'dish_id' => $item->attributes->dishserving->dish_id,
                    'serving_id' => $item->attributes->dishserving->serving_id,
                    'count' => $item->quantity,
                ]);
            };

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
        if (Auth::user()->hasRole('user') && ($order = $this->getUserEditOrder($id))) {
            return $this->returnEditView($order, $id, Cart::getTotalQuantity());
        } elseif (Auth::user()->hasRole('kitchener') && ($order = $this->getKitchenerEditOrder($id))) {
            return $this->returnEditView($order, $id, Cart::getTotalQuantity());
        } else {
            return redirect()->route('orders.index')->withError('Заказ №' . $id . ' не может быть изменен.');
        }
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
        } elseif (Auth::user()->hasRole('kitchener')) {
            $order = $this->getDeadlineTime() < Carbon::now() ? $this->getKitchenerEditOrder($id) : null;
            $client = null;
        }
        if (!$order) {
            return redirect()->route('orders.index')->withError('Запрещено.');
        }

        $dinnerTime = $client ? $request->dinner_time : $order->dinner_time;
        $status = $client ? 1 : $request->status;
        $addressId = $client ? $request->address_id : $order->address_id;

        if (false !== array_search($order->status, $this->getAvailableStatuses())) {
            $order->status = $status;
            $order->dinner_time = $dinnerTime;
            $order->address_id = $addressId;
            $order->save();
            return redirect()->route('orders.index')->withStatus('Заказ №' . $id . ' сохранен.');
        } else {
            return redirect()->route('orders.index')->withError('Заказ №' . $id . ' не может быть изменен.');
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
        if (Auth::user()->hasRole('user') && $order = $this->getUserEditOrder($id)) {
            $order->orderDishServings->map(function ($item) {
                $item->delete();
            });
            $order->delete();
        }
        return redirect()->route('orders.index')->withStatus('Заказ №' . $id . 'удален.');
    }


    // Protected functions

    protected function getDeadlineTime(): Carbon
    {
        return Carbon::today()->addHours(config('deadline.deadline'));
    }

    protected function getComparisonOperator(): string
    {
        if (Auth::user()->hasRole('user')) {
            return ($this->getDeadlineTime() > Carbon::now()) ? '<' : '>';
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
        } else {
            return [];
        }
    }

    protected function returnEditView(Order $order, int $id, int $quantity): ?View
    {
//        dump($order);
//        dump($id);
//        dump($quantity);
//        dump(Auth::user());
        return view('home')
            ->with([
                'order_edit' => $order,
                'page_title' => 'Заказ №' . $id,
                'basket' => $quantity,
            ]);
//        dump(4);
    }

    protected function getUserAddresses(User $user): array
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

    protected function getKitchenerEditOrder(int $id): ?Order
    {
        return Order::where('id', $id)
            ->whereIn('status', $this->getAvailableStatuses())
            ->where('created_at', $this->getComparisonOperator(), $this->getDeadlineTime())
            ->first();
    }
}