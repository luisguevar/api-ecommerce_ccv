<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "data" => ProductCResource::collection($this->collection),
        ];
    }
}
