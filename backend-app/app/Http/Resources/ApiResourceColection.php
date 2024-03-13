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
            ],
        ];
    }
}
