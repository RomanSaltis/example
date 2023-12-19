<?php

namespace App\Http\Controllers;

use App\Models\CarUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarUserController extends Controller
{
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'car_id'=>['integer', 'unique:car_user', 'min:1', 'max:10000'],
            'user_id'=>['required', 'integer',  'min:1', 'max:10000'],
            'start'=>['required', 'date'],
            'end'=>['required', 'date', 'after_or_equal:start'],
        ]);
        $validated = $validator->validated();
            return response()->json(CarUser::create($validated));
    }

    public function edit(Request $request, string $id) : JsonResponse
    {
        $carUser = CarUser::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'end'=>['required', 'date', 'after_or_equal:start'],
        ]);
        $validated = $validator->validated();
        $carUser->update($validated);
        return response()->json($carUser);
    }

    public function delete(Request $request, string $id) : JsonResponse
    {
        $carUser = CarUser::findOrFail($id);
        return response()->json($carUser->delete());
    }
}
