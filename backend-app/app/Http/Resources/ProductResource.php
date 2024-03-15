<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_product' => $this->name_product,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $this->image,
            'description' => $this->description,
            'category' => $this->whenLoaded('category', function($category){
                return [
                    'name_category' => $category->name_category,
                ];
            }),
            'store' => $this->whenLoaded('store', function($store){
                return [
                    'name_store' => $store->name_store,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
