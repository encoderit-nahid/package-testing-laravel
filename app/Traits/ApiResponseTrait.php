<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function success($message, $data = null, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function failure($message, $status = 400, $errors = null): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];
        if ($errors) {
            if (is_array($errors)) {
                $response['errors'] = $errors;
            } elseif (is_string($errors)) {
                $response['error'] = $errors;
            } else {
                $response['error'] = 'An unexpected error occurred.';
            }
        }

        return response()->json($response, $status);
    }
}
