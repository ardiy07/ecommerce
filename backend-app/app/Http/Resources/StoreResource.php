<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'store_id' => $this->id,
            'name_store' => $this->name_store,
            'products' => $this->whenLoaded('product', function () {
                return [
                    'data_product' => $this->product->map(function ($product) {
                        return [
                            "id" => $product->id,
                            "name_product" => $product->name_product,
                            "price" => $product->price,
                            "stock" => $product->stock,
                            "image" => $product->image,
                            "description" => $product->description,
                            "category_product" => $product->category->name_category,
                        ];
                    }),
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
