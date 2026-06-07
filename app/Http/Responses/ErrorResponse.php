<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ErrorResponse
{
    public static function notFound(
        string $message = 'Not found', 
        array $errors = []
    ): JsonResponse {
        return self::response(
            $message,
            $errors,
            404
        );
    }

    public static function forbidden(
        string $message = 'Forbidden', 
        array $errors = []
    ): JsonResponse {
        return self::response(
            $message,
            $errors,
            403
        );
    }

    public static function unauthorized(
        string $message = 'Unauthorized', 
        array $errors = []
    ): JsonResponse {
        return self::response(
            $message,
            $errors,
            401
        );
    }

    private static function response(
        string $message, 
        array $errors = [], 
        int $httpCode = 200
    ): JsonResponse {
        return response()->json([
            'message'   => $message,
            'errors'    => $errors
        ], $httpCode);
    }
}
