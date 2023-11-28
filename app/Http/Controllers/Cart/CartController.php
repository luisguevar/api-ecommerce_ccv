<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartShopCollection;
use App\Http\Resources\Cart\CartShopResource;
use App\Models\Cart\CartShop;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = CartShop::where("user_id", auth('api')->user()->id)->orderBy("id",  "desc")->get();
        return response()->json(["carts" => CartShopCollection::make($carts)]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validacion de stock

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->cantidad) {
            return response()->json(["message" => 403, "message_text" => "EL PRODUCTO NO SE ENCUENTRA EN STOCK"]);
        }

        $cart_shop = CartShop::create($request->all());
        return response()->json(["message" => 200, "cart_shop" => CartShopResource::make($cart_shop)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validacion de stock

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->cantidad) {
            return response()->json(["message" => 403, "message_text" => "EL PRODUCTO NO SE ENCUENTRA EN STOCK"]);
        }

        $cart_shop = CartShop::findOrFail($id);
        $cart_shop->update($request->all());
        return response()->json(["message" => 200, "cart_shop" => CartShopResource::make($cart_shop)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart_shop = CartShop::findOrFail($id);
        $cart_shop->delete();
        return response()->json(["message" => 200]);
    }
}
