<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Success Response
     */
    protected function success(mixed $data = [], string $messageKey = 'messages.success.saved', int $statusCode = 200): JsonResponse
    {
        $message = __($messageKey);

        if ($message === $messageKey) {
            $message = $messageKey; // Fallback if key not found
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Error Response
     */
    protected function error(string $messageKey = 'messages.error.unexpected', int $statusCode = 400, mixed $errors = []): JsonResponse
    {
        $message = __($messageKey);

        if ($message === $messageKey) {
            $message = $messageKey;
        }

        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($errors !== []) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
