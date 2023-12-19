<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidInputException;
use App\Models\CompanyOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyOfficeController extends Controller
{
    public function store(Request $request): object
    {
        $validator = Validator::make($request->all(), [
            'name' => ['min:2', 'max:200'],
            'country' => ['required', 'min:2', 'max:100'],
            'city' => ['required', 'min:2', 'max:100'],
            'street' => ['required', 'min:2', 'max:100'],
            'nr' => ['required', 'min:2', 'max:50'],
            'postal_code' => ['required', 'min:2', 'max:50'],
            'company_id' => ['required', 'integer'],
        ]);
        $validated = $validator ->validated();
        $companyOffice = CompanyOffice::create($validated);
        return $companyOffice;
    }

public function edit(Request $request, string $id): object
    {
        $companyOffice = CompanyOffice::find($id);

        $validator = Validator::make($request->all(), [
            'name' => ['min:2', 'max:200'],
            'country' => ['required', 'min:2', 'max:100'],
            'city' => ['required', 'min:2', 'max:100'],
            'street' => ['required', 'min:2', 'max:100'],
            'nr' => ['required', 'min:2', 'max:50'],
            'postal_code' => ['required', 'min:2', 'max:50'],
        ]);
        $validated = $validator->validated();

        if (is_null($companyOffice)) {
            throw new InvalidInputException("Office with id {$id} cannot be found");
        }
        $companyOffice->update($validated);
        return $companyOffice;
    }
}
