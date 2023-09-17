<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductCCollection;
use App\Http\Resources\Product\ProductCResource;
use App\Models\Product\Categorie;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::filterProduct($search)->orderBy("id", "desc")->paginate(30);
        return response()->json([
            "message" => 200,
            "total" => $products->total(),
            "products" => ProductCCollection::make($products),
        ]);
    }

    public function getCategorias()
    {
        $categories = Categorie::orderBy("id", "desc")->get();
        return response()->json(["categories" => $categories]);
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
        $is_exist_product =  Product::where("title", $request->title)->first();
        if ($is_exist_product) {
            return response()->json(["message" => 403]);
        }

        /*   $request->request->add(["tags" => implode(",", $request->tags_e)]); */ //convertir json a string
        $request->request->add(["slug" => Str::slug($request->title)]);

        if ($request->hasFile("imagen_file")) { //imagen principal
            $path = Storage::putFile("productos", $request->file("imagen_file"));
            $request->request->add(["imagen" => $path]);
        }

        $product = Product::create($request->all()); //Creacion del producto

        foreach ($request->file("files") as $key => $file) { //Subida de galeria de imagenes

            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $nombre  = $file->getClientOriginalName();
            $path =  Storage::putFile("productos", $file);
            ProductImage::create([
                "product_id" => $product->id,
                "file_name" => $nombre,
                "imagen" =>  $path,
                "size" =>  $size,
                "type" => $extension
            ]);
        }

        return response()->json(["message" => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([

            "product" => ProductCResource::make($product)
        ]);
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
        $is_exist_product =  Product::where("id", "<>", $id)->where("title", $request->title)->first();
        if ($is_exist_product) {
            return response()->json(["message" => 403]);
        }

        $product = Product::findOrFail($id);

        $request->request->add(["slug" => Str::slug($request->title)]);

        if ($request->hasFile("imagen_file")) { //imagen principal
            $path = Storage::putFile("productos", $request->file("imagen_file"));
            $request->request->add(["imagen" => $path]);
        }

        $product->update($request->all());



        return response()->json(["message" => 200]);
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
