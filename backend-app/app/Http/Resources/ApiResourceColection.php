<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResourceColection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = $this->status ?? 'succes';
        return [
            'status' => $status,
            'data' => $this->collection,
            'meta' => [
                'total' => $this->collection->count(),
                'accessed_at' => now(),
                'pagination' => [
                    'total' => $this->resource->total(), // Total item
                    'per_page' => $this->resource->perPage(), // Item per halaman
                    'current_page' => $this->resource->currentPage(), // Halaman saat ini
                    'last_page' => $this->resource->lastPage(), // Halaman terakhir
                    'next_page_url' => $this->resource->nextPageUrl(), // URL halaman berikutnya
                    'prev_page_url' => $this->resource->previousPageUrl(), // URL halaman sebelumnya
                    'from' => $this->resource->firstItem(), // Item pertama dalam halaman saat ini
                    'to' => $this->resource->lastItem(), // Item terakhir dalam halaman saat ini
                ],
            ],
        ];
    }
}
