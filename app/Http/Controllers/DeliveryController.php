<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Requests\DeliveryStoreRequest;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the deliveries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('user')
            ->where('execution', Carbon::now()->format('Y-m-d'))
            ->where('sms', 0)
            ->get()->groupBy('dinner_time')->sort()->reverse()
            ->map(function ($item, $key) {
                return $item->map(function ($item, $key) {
                    return $item->user->address;
                })->unique();
            });
        return view('delivery.index')->with(['orders' => $orders]);
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
    public function store(DeliveryStoreRequest $request)
    {
        $orders = Order::with('user')
            ->where('execution', Carbon::now()->format('Y-m-d'))
            ->where('dinner_time', $request->dinner_time)
            ->whereHas('user', function ($query) {
                global $request;
                $query->where('address_id', $request->address_id);
            })
            ->get();

        $users = $orders->map(function ($item, $key) {
            return $item->user;
        })->unique();

        $phones = $users->map(function ($item, $key) {
            return $item->phone;
        });

        dump($orders);
        dump($users);
        dump($phones);

//        $orders->update(['sms' => 1]);
//        return redirect()->route('orders.index')->withStatus('Сообщение о доставке по адресу ' . Address::find($request->address_id)->description . ' отправлено');
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
        //
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
        //
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
