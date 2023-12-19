<?php declare(strict_types=1);

use Illuminate\Http\JsonResponse as JsonResponse;

function answer(mixed $data): JsonResponse
{
    return response()->json($data);
}
