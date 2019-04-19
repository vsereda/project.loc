<?php

namespace App\Http\Controllers;

use App\DishServing;
use App\Http\Requests\ConfirmOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Order;
use App\OrderDishServing;
use App\Rules\DishServingNotEmpty;
use App\Rules\DishServingRule;
use App\User;
use Carbon\Carbon;
use function Couchbase\defaultDecoder;
use Darryldecode\Cart\CartCollection;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use function PHPSTORM_META\type;

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


    public function tasks()
    {
        $kitchenTaskList = $this->getKitchenTaskList();
        $kitchenTaskList1 = $this->getKitchenTaskList(1);
        $kitchenTaskList2 = $this->getKitchenTaskList(2);
        $kitchenTaskList3 = $this->getKitchenTaskList(3);

        return view('kitchen.tasks')->with([
            'page_title' => 'Задания',
            'kitchenTaskList' => $kitchenTaskList,
            'kitchenTaskList1' => $kitchenTaskList1,
            'kitchenTaskList2' => $kitchenTaskList2,
            'kitchenTaskList3' => $kitchenTaskList3,
        ]);
    }

    /**
     * Display listing of orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        session()->forget('order_edit_back_url');
        if (Auth::user()->hasRole('user')) {
//            $kitchenTaskList = null;
            $ordersPaginated = $this->getUserOrders(self::PAGINATE, Auth::user());
            $pageTitle = 'Заказы';
            $view = 'user.orders';
        } elseif (Auth::user()->hasRole('kitchener')) {
            $ordersPaginated = $this->getKitchenerOrders(self::PAGINATE);
//            $pageTitle = ($this->getDeadlineTime() > Carbon::now())
//                ? 'Заказы еще могут быть изменены или удалены клиентом'
//                : 'Не готовые заказы зафиксированы и подлежат выполнению';
            $pageTitle = 'Заказы на сегодня';
            $view = 'kitchen.orders';
        }

        return view($view)->with([
            'orders' => $ordersPaginated,
            'page_title' => $pageTitle,
//            'basket' => Cart::getTotalQuantity(),
//            'kitchenTaskList' => $kitchenTaskList,
        ]);
    }

    /**
     * Show the form for creating a new order.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateOrderRequest $request)
    {
        $dsString = $this->dsString($request);

        if (count($dsString->keys()) && !($dishservings = $this->getDishservings($dsString->keys()))->contains(null)) {

            $dishServingCounts = $this->dishServingCounts($dishservings, $dsString);
            $total = $this->getTotalCost($dishServingCounts);

            return view('create_order')->with([
                'page_title' => 'Оформление заказа: итого ' . $total . 'грн.',
                'total' => $total,
                'dishServingCounts' => $this->dishServingCounts($dishservings, $dsString),
                'executionDate' => $this->executionDate(),
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
//    public function store(Request $request)
    {
//        if (Auth::user()->hasRole('user')) {
//            dd($request);
//            $validatedData = $request->validate([
//                'dinner_time' => [
//                    'required',
//                    Rule::in([1, 2, 3]),
//                ],
//                'dish_servings' => [
//                    new DishServingRule,
//                    new DishServingNotEmpty(),
//                ]
//            ]);

//            dd($validatedData);
        $order = Order::create([
            'address_id' => Auth::user()->addresses->first()->id,
//                'dinner_time' => $validatedData['dinner_time'],
            'dinner_time' => $request->dinner_time,
            'status' => 1,
            'execution' => $this->executionDate(),
        ]);

        $this->createOrderDishservings($request, $order);


        return redirect()->route('products.index')->withStatus('Заказ создан');
//        }
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
//        session(['order_edit_back_url' => url()->previous()]);

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
        return view('kitchen.order_edit')->with([
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
//        return Order::where('created_at', $this->getComparisonOperator(), $this->getDeadlineTime())
//            ->whereIn('status', $this->getAvailableStatuses())
//            ->orderBy('status')
//            ->orderBy('dinner_time')
//            ->orderBy('id')
//            ->paginate($paginate);

        return Order::where('execution', Carbon::now()->format('Y-m-d'))
//            ->whereIn('status', [1])
//            ->whereIn('status', $this->getAvailableStatuses())
//            ->orderBy('status')
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

    protected function createOrderDishservings(Request $validatedData, Order $order)
    {
//        dd(get_class($validatedData));
        foreach ($validatedData['dish_servings'] as $key => $ds) {
            if (null !== $ds) {
                $delimiterPosition = strpos($key, '/');
                OrderDishServing::create([
                    'order_id' => $order->id,
                    'dish_id' => substr($key, 0, $delimiterPosition),
                    'serving_id' => substr($key, $delimiterPosition + 1),
                    'count' => $ds,
                ]);
            }
        };
    }

    protected function getNotMadeOrders(int $dinnerTime = 0)
    {
        $dinnerTimeList = $dinnerTime ? [$dinnerTime] : [1, 2, 3];
//        return Order::where('created_at', $this->getComparisonOperator(), $this->getDeadlineTime())
//            ->whereIn('status', [1])
//            ->whereIn('dinner_time', $dinnerTimeList)
//            ->with(['orderDishServings'])
//            ->get();

        return Order::where('execution', Carbon::now()->format('Y-m-d'))
            ->whereIn('status', [1])
            ->whereIn('dinner_time', $dinnerTimeList)
            ->with(['orderDishServings'])
            ->get();
    }

    protected function getKitchenTaskList(int $dinnerTime = 0): Collection
    {
        $list = $this->getNotMadeOrders($dinnerTime)->map(function ($item) {
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
//        dd(get_class($x));
        return $list;
    }

    protected function getDishservings(Collection $dishServingIDs): Collection
    {
        foreach ($dishServingIDs as $ds) {
            $dishServings[] = DishServing::find([
                'dish_id' => substr($ds, 0, strpos($ds, '/')),
                'serving_id' => substr($ds, strpos($ds, '/') + 1),
            ]);
        }
        return collect($dishServings);
    }

    protected function dsString(FormRequest $request)
    {
        return collect($request->dish_servings)->filter(function ($value, $key) {
            return is_numeric($value) && $value > 0;
        });
    }

    protected function dishServingCounts(Collection $dishservings, Collection $dsString)
    {
        $dishServingCounts = [];
        foreach ($dishservings as $key => $ds) {
            $dishServingCounts[] = [
                'ds' => $ds,
                'count' => $dsString->flatten()[$key],
            ];
        }
        return $dishServingCounts;
    }

    protected function getTotalCost(array $dishServingCounts)
    {
        $total = 0;
        foreach ($dishServingCounts as $dsCount) {
            $total += $dsCount['count'] * $dsCount['ds']->price;
        }
        return $total;
    }

    protected function executionDate(): Carbon
    {
        switch (Carbon::tomorrow()->dayOfWeek) {
            case 6:
                return Carbon::now()->addDays(3);
            case 0:
                return Carbon::now()->addDays(2);
            default:
                return Carbon::tomorrow();
        }
    }
}