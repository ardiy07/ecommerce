<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $productId = $this->route('id');
        $product = Product::findOrFail($productId);
        $isMerchant = auth()->user()->hasRole('merchant');
        $isMatchingStore = $product->store_id === auth()->user()->store->id;   
        return $isMerchant && $isMatchingStore;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_product' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'category_product_id' => 'required|exists:category_products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
