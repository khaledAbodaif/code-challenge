<?php

namespace App\Infrastructure\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{


    public static function error(string $message = "Sorry Something Went Wrong", int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(
            [
                'status' => false,
                'message' => $message
            ], $code);
    }

    public static function dataCreated(mixed $data, string $message = "Data Created Successfully", int $code = Response::HTTP_CREATED): JsonResponse
    {

        return response()->json(
            [
                'status' => true,
                'message' => $message,
                'data' => $data
            ], $code);
    }

}
