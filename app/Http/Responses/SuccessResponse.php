<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class SuccessResponse
{
    public static function ok(
        string $message = 'Success', 
        array $data = []
    ): JsonResponse {
        return self::response(
            $message,
            $data,
            200
        );
    }

    public static function created(
        string $message = 'Created', 
        array $data = []
    ): JsonResponse {
        return self::response(
            $message,
            $data,
            201
        );
    }

    public static function noContent(): JsonResponse
    {
        return response()->json([], 204);
    }

    private static function response(
        string $message, 
        array $data = [], 
        int $httpCode = 200
    ): JsonResponse {
        return response()->json([
            'message'   => $message,
            'data'      => $data
        ], $httpCode);
    }
}
