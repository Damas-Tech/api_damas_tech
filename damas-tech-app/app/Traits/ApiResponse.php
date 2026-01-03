<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Success Response
     *
     * @param mixed $data
     * @param string $messageKey
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function success($data = [], string $messageKey = 'messages.success.saved', int $statusCode = 200): JsonResponse
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
     *
     * @param string $messageKey
     * @param int $statusCode
     * @param mixed $errors
     * @return JsonResponse
     */
    protected function error(string $messageKey = 'messages.error.unexpected', int $statusCode = 400, $errors = []): JsonResponse
    {
        $message = __($messageKey);

        if ($message === $messageKey) {
            $message = $messageKey;
        }

        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
