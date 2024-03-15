<?php

namespace App\Http\Requests\Store;

use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        try{
            $storeId = $this->route('id');
            $store = Store::findOrFail($storeId);
            $isMerchant = Auth::user()->hasRole('merchant');
            $isMatchingStore = $store->store_id === auth()->user()->store->id;
            return $isMerchant && $isMatchingStore;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_store' => 'required|string|max:100|unique:stores,name_store'
        ];
    }
}
