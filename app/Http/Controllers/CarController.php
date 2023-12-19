<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidInputException;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Js;

class CarController extends Controller
{
    public function store(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'brand'=>['required', 'min:1', 'max:100'],
            'model'=>['required', 'min:1', 'max:100'],
            'price'=>['required', 'min:1', 'max:100'],
            'company_id' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);
        $validated = $validator->validated();
        return response()->json(Car::create($validated));
    }

    public function edit(Request $request, string $id) : JsonResponse
    {
        $car = Car::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'brand'=>['min:1', 'max:100'],
            'model'=>['min:1', 'max:100'],
            'price'=>['min:1', 'max:100'],
            'company_id' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);
        $validated = $validator->validated();
        $car->update($validated);
        return response()->json($car);
    }

//    public function removeUser(Request $request){
//        $car = Car::where('user_id', '=', $request->user_id)->first();
//        $car->update(['user_id'=>null]);
//        return $car;
//    }

    public function delete(Request $request, string $id): JsonResponse
    {
        $car = Car::findOrFail($id);
        return response()->json($car->delete());
    }
}
