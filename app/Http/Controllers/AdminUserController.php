<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidInputException;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'integer', 'unique:admin_users'],
                'is_admin' => ['boolean'],
            ]
        );
        $validated = $validator->validated();
        return response()->json(AdminUser::create($validated));
    }


    public function edit(Request $request, string $id) : JsonResponse
    {
        $isAdmin = AdminUser::findOrFail($id);
        $validator = Validator::make($request->all(), [
                'is_admin' => ['boolean'],
            ]
        );
        $validated = $validator->validated();
        $isAdmin->update($validated);
        return response()->json($isAdmin);
    }

    public function delete(Request $request, string $id): JsonResponse
    {
        $isAdmin = AdminUser::findOrFail($id);
        return response()->json($isAdmin->delete());
    }
}
