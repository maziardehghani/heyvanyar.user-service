<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{

    protected function successResponse($data, $code = Response::HTTP_OK, $message = null): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'status_code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($code, $message = null, $data = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'status_code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function responseIf($condition, $code, $message = null, $data = null): JsonResponse|null
    {
        if (!$condition) {
           return null;
        }

        return response()->json([
        'status_code' => $code,
        'message' => $message,
        'data' => $data
    ], $code);

    }

    protected function paginateResponse($data, array $relations, $resource, $message): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $resource::collection($data->load($relations)),
            'links' => $resource::collection($data)->response()->getData()->links,
            'meta' => $resource::collection($data)->response()->getData()->meta

        ],Response::HTTP_OK);
    }
}
