<?php

namespace App\Traits\V1;
trait GlobalApiResponse
{
    protected function successResponse(
        mixed $data = null,
        string $message = "Record successful.",
        int $statusCode = 200) : mixed
    {
        return response()->json([
            'status' => 1,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    protected function errorResponse(
        string $message = "Record failed.",
        mixed $errors = null,
        int $statusCode = 422) : mixed
    {
        return response()->json([
            'status' => 0,
            'errors' => $errors,
            'message' => $message,
        ], $statusCode);
    }


}
