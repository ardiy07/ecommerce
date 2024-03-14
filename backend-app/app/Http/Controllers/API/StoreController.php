<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResourceColection;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('product')->get();
        $expensiveStores = new ApiResourceColection(StoreResource::collection($stores), 'failed');
        return $expensiveStores->response()->setStatusCode(200);
    }

    public function show($id)
    {
        try {
            $store = Store::with('product')->findOrFail($id);
            $expensiveStore = new StoreResource($store);
            return $expensiveStore->response()->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed', 'message' => 'Data Tidak Ditemukan'], 404);
        }
    }

    public function create(Request $request)
    {
        try {
            // Validasi Input
            $validator = Validator::make($request->all(), [
                'name_store' => 'required|string|max:100|unique:stores,name_store'
            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

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
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Cek store
            $store = Store::findOrFail($id);

            // Cek kepemilikan store
            if ($store->user_id !== auth()->user()->id) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Validasi Input
            $validator = Validator::make($request->all(), [
                'name_store' => 'required|string|max:100|unique:stores,name_store'
            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            //  Update Store
            $store->update([
                'name_store' => $request->name_store
            ]);

            return response()->json(['status' => 'Sukses', 'data' => $store], 200);

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function destroy($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'Invalid store ID'], 400);
        }

        try {
            $store = Store::findOrFail($id);
            $store->delete();
            return response()->json(['message' => 'Store Berhasil di Hapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Store Tidak Ditemukan'], 404);
        }
    }
}
