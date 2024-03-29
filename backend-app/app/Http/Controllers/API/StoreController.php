<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Http\Resources\ApiResourceColection;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $page = 1;
        $stores = Store::with('product')->paginate($limit, ['*'], 'page', $page);;
        $expensiveStores = new ApiResourceColection(StoreResource::collection($stores), 'failed');
        return $expensiveStores->response()->setStatusCode(200);
    }

    public function show(string $id)
    {
        try {
            $store = Store::with('product')->findOrFail($id);
            $expensiveStore = new StoreResource($store);
            return $expensiveStore->response()->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Data Tidak Ditemukan'], 404);
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            // Menyimpan store
            $store = Store::create([
                'name_store' => $request->name_store,
                'user_id' => auth()->user()->id,
            ]);

            $user = auth()->user();

            // Menghapus peran 'buyer'
            if ($user->hasRole('buyer')) {
                $user->removeRole('buyer');
            }

            // Memberikan peran 'merchant' kepada pengguna
            $user->assignRole('merchant');

            return response()->json(['status' => 'Sukses', 'data' => $store], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function update(UpdateStoreRequest $request,string $id)
    {
        try {
            // Cek store
            $store = Store::findOrFail($id);
            $store->lockForUpdate();

            //  Update Store
            $store->fill($request->all());
            $store->save();

            return response()->json(['status' => 'Sukses', 'data' => $store], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $store = Store::findOrFail($id);
            $store->delete();
            return response()->json(['message' => 'Store Berhasil di Hapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Store Tidak Ditemukan'], 404);
        }
    }
}
