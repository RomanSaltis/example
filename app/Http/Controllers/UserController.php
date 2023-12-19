<?php

namespace App\Http\Controllers;

use App\Enums\GenderType;
use App\Events\Authenticated;
use App\Events\UserCreatedEmail;
use App\Exceptions\EmailException;
use App\Exceptions\InvalidInputException;
use App\Exceptions\ValidationEmailStructureException;
use App\Exceptions\ValidationNameException;
use App\Exceptions\ValidationPasswordException;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use PhpParser\Node\Stmt\If_;
use PHPUnit\Framework\Error;


class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws EmailException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:7', 'max:255'],
            'gender' => ['required', new Enum(GenderType::class)],
            ]
        );

        $validated = $validator->validated();
        $validated['activation_code']= Hash::make(Str::random(64));

        $user = User::get();
        if ($request->has('email') && is_string($request->email) && $user->where('email', $request->email)->first()) {
            throw new EmailException("email {$request->email} already exists");
        }
            return response()->json(User::create($validated), 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function verify(Request $request): JsonResponse|RedirectResponse
    {
        $user=User::where('email', '=', $request->email)->first();
        $userCode=$user->where('activation_code', '=', $request->activation_code)->first();
        if (!$user->email_verified){
            if ($user&&$userCode){
                $user->update(['email_verified'=>'true']);
                event(new Authenticated($user));
                return redirect('api/verified');
            }else{
              return response()->json("OOPs, your email or activation code doesn't meet");
            }
        } else {
           return response()->json("OOPs, your email already activated. Please enter your password");
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:7', 'max:255'],
        ]);
        $user=User::where('email', '=', $request->email)->first();
        $validated=$validator->validated();
        if (Auth::attempt($validated)&&$user->email_verified){
            return answer($this->issueToken($request));
        } else{
            return answer('entered invalid credentials or your email not activated');
        }
    }

    public function issueToken(Request $request, string $grant_type='password', string $scope = ''): JsonResponse
    {
        $params = [
            'grant_type' => $grant_type,
            'client_id' => config('client.client_id', 'CLIENT_ID_ROMAN'),
            'client_secret' => config('client.secret_key', 'CLIENT_SECRET_ROMAN'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => $scope,
        ];
        $request = Request::create('oauth/token', 'POST', $params);
        return answer(app()->handle($request));
    }

    public function refreshToken(string $grant_type='refresh_token', string $scope = ''): JsonResponse
    {
        $params = [
            'grant_type' => $grant_type,
            'refresh_token' => 'def50200c400c686465a261524d2aed7c5911a5b9abcc52e0d340017d09c185be0e69093281a3f711643cd243461efe142528512bcc272c6a411555c1e1a798c271b86cc5ae8a5feed416db0f0904e5454e2f1d54a65e784224de8dc7786611e8723356681df781f71d7421b0ec31b69df350397b0e3f0be52f873fb159f3f346fbe14cf7115357fd0e80a786c08b792b7f39ed42f5646bd9c7dd8ae13e06286679dc7a4aa46b95614e8aef8607b6d91e2f11c9caf8422b7b0da1e9ea5ce475ec9dbe253fc12942f41bb31e6e0baf589c5c51947347b5c2c3ad169753b206cd27b5e7a4f1a496b95624475904a042958bf25d40fec5220d6db673dbc639617756690cdba86ff585d109ac5f44fae8d4ec0782acea1e124f095e4d5f31233a9fd55859c3f3df166bc1b39cd80a9b919e9787d23193a23a5534fdf9329289be0e133ad2c1c010186190236827406f142b901d772e74f130c271c0554a5a801321cc874',
            'client_id' => 9,
            'client_secret' => config('client.secret_key', 'CLIENT_SECRET_ROMAN'),
            'scope' => $scope,
        ];
        $request = Request::create('oauth/token', 'POST', $params);
        return answer(app()->handle($request));
    }

    public function me(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }

    public function test(Request $request): JsonResponse{
        return response()->json($request->headers);
    }

    public function edit(Request $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => ['min:2', 'max:255'],
            'email' => ['email', 'max:255'],
            'password' => ['min:7', 'max:255'],
            'gender' => [ new Enum(GenderType::class)],
        ]);

        $validated = $validator->validated();
        $user->update($validated);
        return response()->json($user);
    }

    public function delete(Request $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json($user->delete());
    }
//
    public function user(Request $request, string $id) : JsonResponse
    {
        return response()->json(User::findOrFail($id));
    }






}
