<?php

namespace App\Http\Controllers;

use App\DishServing;
use App\Http\Middleware\ProductsMiddleware;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class BasketController extends Controller
{
    public function __construct()
    {
        $this->middleware(ProductsMiddleware::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Cart::getTotal()){
            return redirect()->route('home');
        }
        return view('home')->with([
            'page_title' => 'Корзина: всего ' . Cart::getTotal() . 'грн.',
            'basket_content' => Cart::getContent(),
        ]);
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
        if (($ds = DishServing::where(['dish_id' => $request->dish, 'serving_id' => $request->serving])->first()) && 1 <= $request->count) {
            Cart::add(
                $request->dish . '.' . $request->serving,
                $ds->dish->title,
                $ds->price,
                $request->count,
                ['dishserving' => $ds]
            );
            return redirect()->route('products.index')->withStatus($ds->dish->title . ' ' . $ds->serving->title . ' &nbsp;&nbsp;&nbsp;&nbsp;' . $request->count . ' шт. добавлено в корзину');
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
        $name = Cart::get($id)->name;
        Cart::remove($id);
        return redirect()->back()->withStatus('Товар ' . $name . ' удален из корзины.');
    }
}
