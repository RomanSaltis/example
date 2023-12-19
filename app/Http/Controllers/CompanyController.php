<?php

namespace App\Http\Controllers;

use App\Enums\Country;
use App\Exceptions\InvalidInputException;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use phpseclib3\Math\PrimeField\Integer;

class CompanyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(\Illuminate\Http\Request $request) : JsonResponse
        {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:20'],
            'country'=>['required', new Enum(Country::class)],
        ]);
        $validated = $validator->validated();

        return response()->json(Company::create($validated));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return JsonResponse
     * @throws InvalidInputException
     */
    public function edit(\Illuminate\Http\Request $request, string $id): JsonResponse
    {
        $validated = request()->validate([
            'name' => ['min:2', 'max:255'],
            ]);
        $companyId = Company::findOrFail($id);
        $companyId->update($validated);
        return response()->json($companyId);

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return JsonResponse
     * @throws InvalidInputException
     */
    public function delete(\Illuminate\Http\Request $request, string $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        return response()->json($company->delete());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function findCompanyName(\Illuminate\Http\Request $request): JsonResponse
    {
        $name = Company::with('users');

        if($request->has('name'))
        {
            $name->where('companies.name', $request->name);
        }
        return response()->json($name->get());
    }
}
