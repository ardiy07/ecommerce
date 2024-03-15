<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ApiResourceColection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $limit = $request->input('limit', 10);
            $page = 1;

            // Jika ada kriteria pencarian, filter hasil berdasarkan pencarian
            if ($search) {
                $products = Product::with(['store', 'category'])
                    ->where('name_product', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('store', function ($query) use ($search) {
                        $query->where('name_store', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name_category', 'LIKE', '%' . $search . '%');
                    })
                    ->paginate($limit, ['*'], 'page', $page); // Gunakan nilai Page dalam metode paginate
                if ($products->isEmpty()) {
                    return response()->json(['message' => 'Data not found'], 404);
                }
            } else {
                // Jika tidak ada kriteria pencarian, ambil semua produk dengan pagination
                $products = Product::with(['store', 'category'])->paginate($limit, ['*'], 'page', $page);
            }
            $expensiveProducts = new ApiResourceColection(ProductResource::collection($products), 'failed');
            return $expensiveProducts->response()->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json(['Message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            // Simpan gambar ke penyimpanan dan dapatkan URL-nya
            $imagePath = $request->file('image')->store('public/images/products');
            $imageUrl = Storage::url($imagePath);


            // Buat produk baru
            $product = Product::create([
                'name_product' => $request->name_product,
                'image' => $imageUrl,
                'price' => $request->price,
                'stock' => $request->stock,
                'description' => $request->description,
                'store_id' => auth()->user()->store->id,
                'category_product_id' => $request->category_product_id
            ]);

            // Ambil produk baru
            $productWithRelations = Product::with(['store', 'category'])->find($product->id);

            // Kembalikan respons
            return (new ProductResource($productWithRelations))
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::with(['store', 'category'])->findOrFail($id);
            $expensiveProduct = new ProductResource($product);
            return $expensiveProduct->response()->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Data Tidak Ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);
            // Cek apakah ada file gambar yang diupload
            if ($request->hasFile('image')) {
                // Hapus gambar sebelumnya dari penyimpanan
                Storage::delete($product->image);

                // Simpan gambar baru ke penyimpanan dan dapatkan URL-nya
                $imagePath = $request->file('image')->store('public/images/products');
                $imageUrl = Storage::url($imagePath);

                // Update produk dengan gambar baru
                $product->update([
                    'name_product' => $request->name_product,
                    'image' => $imageUrl,
                    'price' => $request->price,
                    'stock' => $request->stock,
                    'description' => $request->description,
                    'category_product_id' => $request->category_product_id
                ]);
            } else {
                // Jika tidak ada gambar yang diupload, hanya update data lainnya
                $product->update([
                    'name_product' => $request->name_product,
                    'price' => $request->price,
                    'stock' => $request->stock,
                    'description' => $request->description,
                    'category_product_id' => $request->category_product_id
                ]);
            }
            return response()->json(['status' => 'Sukses', 'data' => $product], 200);
        } 
        catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->store_id !== auth()->user()->store->id) {
                return response()->json(['message' => 'Tidak ada akses'], 401);
            }
            $product->delete();
            return response()->json(['message' => 'Product Berhasil di Hapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product Tidak Ditemukan'], 404);
        }
    }
}
