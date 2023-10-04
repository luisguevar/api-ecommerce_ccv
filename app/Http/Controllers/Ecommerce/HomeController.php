<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Resources\Ecommerce\Product\ProductEResource;
use App\Models\Product\Categorie;
use App\Models\Product\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $sliders = Slider::orderBy("id", "desc")->get();
        $categories = Categorie::orderBy("id", "desc")->get();
        $products_random_a = Product::inRandomOrder()->limit(8)->get();
        $products_random_b = Product::inRandomOrder()->limit(8)->get();
        $products_random_c = Product::inRandomOrder()->limit(8)->get();
        $products_random_d = Product::inRandomOrder()->limit(8)->get();
        $products_random_e = Product::inRandomOrder()->limit(8)->get();

        return response()->json([
            "sliders" => $sliders->map(function ($slider) {
                return [
                    "id" => $slider->id,
                    "url" => $slider->url,
                    "name" => $slider->name,
                    "imagen" => env("APP_URL") . "storage/" . $slider->imagen
                ];
            }),
            "categories" => $categories->map(function ($categorie) {
                return [
                    "id" => $categorie->id,
                    "name" => $categorie->name,
                    "imagen" => env("APP_URL") . "storage/" . $categorie->imagen,
                    "icono" => $categorie->icono

                ];
            }),
            "products_random_a" => $products_random_a->map(function ($product) {
                return ProductEResource::make($product);
            }),
            "products_random_b" => $products_random_b->map(function ($product) {
                return ProductEResource::make($product);
            }),

            "products_random_c" => $products_random_c->map(function ($product) {
                return ProductEResource::make($product);
            }),

            "products_random_d" => $products_random_d->map(function ($product) {
                return ProductEResource::make($product);
            }),

            "products_random_e" => $products_random_e->map(function ($product) {
                return ProductEResource::make($product);
            }),

        ]);
        /* $group_categories_product = collect([]);

        foreach ($categories as $key => $categorie) {
            $products =  $categorie->products->take(3);
        } */
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
