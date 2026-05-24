<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // 1. Regjistrimi i një përdoruesi të ri përmes API
    Public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        If($validator->fails()){
            Return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'is_admin' => 0 // Regjistrohet si blerës i thjeshtë
        ]);

        $token = JWTAuth::fromUser($user);

        Return response()->json(compact('user','token'), 201);
    }

    // 2. Login përmes API dhe marrja e JWT Token
    Public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        If (! $token = JWTAuth::attempt($credentials)) {
            Return response()->json(['error' => 'Kredencialet janë të gabuara'], 401);
        }

        Return response()->json([
            'message' => 'U loguat me sukses!',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }

    // 3. Marrja e të dhënave të përdoruesit të loguar përmes Token-it
    Public function getAuthenticatedUser()
    {
        Try {
            If (! $user = JWTAuth::parseToken()->authenticate()) {
                Return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            Return response()->json(['token_expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            Return response()->json(['token_invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            Return response()->json(['token_absent'], 401);
        }

        Return response()->json(compact('user'));
    }
}