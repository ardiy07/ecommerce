<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class BaseFormRequest extends FormRequest
{
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json(['error' => 'Tidak Ada Akses'], JsonResponse::HTTP_UNAUTHORIZED)
        );
    }
}
