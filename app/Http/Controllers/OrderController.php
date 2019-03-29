<?php

namespace App\Http\Controllers;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('kitchener')) {
            $orders = Order::where('created_at', '<', Carbon::today()->addHours(config('deadline.deadline')))
                ->whereIn('status', [1, 2])
                ->orderBy('dinner_time')
                ->orderBy('id')
                ->paginate(10);
            return view('home')->with([
                'kitchen_orders' => $orders,
                'page_title' => 'Заказы',
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $order = Order::where('id', $id)->whereIn('status', [1, 2])->first();
        if ($order) {
            return view('home')->with([
                'kitchen_order_edit' => Order::find($id),
                'page_title' => 'Заказ №' . $id,
            ]);
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
        $order = Order::find($id);
        if ($order->status == 1 || $order->status == 2) {
            $order->status = $request->status;
            $order->save();
            return redirect()->route('orders.index')->withStatus('Заказ №' . $id . ' сохранен.');

        } else {
            return redirect()->route('orders.index')->withError('Заказ №' . $id . ' не может быть изменен.');
        }
//        dump($request->status);
//        dump($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
