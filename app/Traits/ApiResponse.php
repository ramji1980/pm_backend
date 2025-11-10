<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Send a success JSON response.
     */
    protected function successResponse($data = null, string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    /**
     * Send an error JSON response.
     */
    protected function errorResponse(string $message = 'Error', int $code = 400, $errors = null)
    {
        $response = [
            'status'  => false,
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Send a validation error JSON response.
     */
    protected function validationErrorResponse($errors, string $message = 'Validation Error', int $code = 422)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}
