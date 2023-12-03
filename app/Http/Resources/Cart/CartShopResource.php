<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->resource->id,
            "user_id" => $this->resource->user_id,
            "user" => [
                "id" =>  $this->resource->client->id,
                "name" => $this->resource->client->name
            ],
            "product" => [
                "id" =>  $this->resource->product->id,
                "title" => $this->resource->product->title,
                "imagen" => env("APP_URL") . "storage/" . $this->resource->product->imagen,
            ],
            "product_id" => $this->resource->product_id,
            "cantidad" => $this->resource->cantidad,
            "precio_unitario" => $this->resource->precio_unitario,
            "subtotal" => $this->resource->subtotal,
            "total" => $this->resource->total
        ];
    }
}
