<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
public function register(RegisterRequest $request): JsonResponse
{
$data = $request->validated();
$user = User::create([
'name' => $data['name'],
'email' => $data['email'],
'password' => Hash::make($data['password']),
]);
$token = JWTAuth::fromUser($user);
return response()->json(['message' => 'Registered','access_token' => $token,'token_type' => 'bearer']);
}


public function login(LoginRequest $request): JsonResponse
{
$credentials = $request->validated();
if (! $token = auth('api')->attempt($credentials)) {
return response()->json(['message' => 'Invalid credentials'], 401);
}
return $this->respondWithToken($token);
}


public function me(): JsonResponse
{ return response()->json(auth('api')->user()); }


public function logout(): JsonResponse
{ auth('api')->logout(); return response()->json(['message' => 'Logged out']); }


public function refresh(): JsonResponse
{ return $this->respondWithToken(auth('api')->refresh()); }


protected function respondWithToken(string $token): JsonResponse
{
return response()->json([
'access_token' => $token,
'token_type' => 'bearer',
'expires_in' => auth('api')->factory()->getTTL() * 60,
]);
}
}