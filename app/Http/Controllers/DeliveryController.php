<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Requests\DeliveryStoreRequest;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mobizon\MobizonApi;
use SendSMS;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the deliveries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $notices = Order::with('user.address')
            ->where('execution', Carbon::now()->format('Y-m-d'))
            ->where('sms', 0)
            ->get()
            ->groupBy('dinner_time')
            ->map(function ($item, $key) {
                $addresses = $item->map(function ($item, $key) {
                    return $item->user->address;
                })->unique()->keyBy('id');

                $users = $item->map(function ($item, $key) {
                    return $item->user;
                })->unique()
                    ->groupBy('address_id');

                return ['users' => $users, 'addresses' => $addresses];
            })
            ->reverse();

        $smsCount = floor(SendSMS::getBalance() / abs(config('mobizon.mobizonprice')));
        return view('delivery.index')->with(['notices' => $notices, 'smsCount' => $smsCount]);
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
     * Store a newly created delivery in storage.
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
            })//            ->get()
        ;

        $users = $orders->get()->map(function ($item, $key) {
            return $item->user;
        })->unique();

        $phones = $users->map(function ($item, $key) {
            return 38 . str_pad($item->phone, 10, '0', STR_PAD_LEFT);
        });
//dd($phones);
        if ($resultError = SendSMS::send($phones, 'Ваш суп прибыл.')['error']) {
//        if ($resultError = $this->sendSMS($phones, 'Ваш суп прибыл.')['error']) {

            return redirect()->route('orders.index')->withError($resultError);
        } else {
            $orders->update(['sms' => 1]);
            return redirect()->route('orders.index')->withStatus('Сообщение о доставке по адресу ' . Address::find($request->address_id)->description . ' отправлено. ');
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