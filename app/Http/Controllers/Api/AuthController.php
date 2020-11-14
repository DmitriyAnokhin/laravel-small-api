<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Exception;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->guard = "api";
    }


    public function registration(RegistrationRequest $request)
    {
        if (User::emailExists($request->email)) {

            throw new Exception('E-mail уже используется', 409);
        }

        $user = User::create(array_merge(
            $request->validated(),
            ['password' => Hash::make($request->password)],
        ));

        return new JsonResource($user);
    }


    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth($this->guard)->attempt($credentials)) {

            throw new Exception('Неверные учетные данные', 401);
        }

        return new JsonResource($this->respondWithToken($token));
    }


    public function logout()
    {
        auth()->logout();

        return new JsonResource(['message' => 'Successfully logged out']);
    }


    public function refresh()
    {
        return new JsonResource($this->respondWithToken(auth($this->guard)->refresh()));
    }


    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL() * 60,
        ];
    }

}
