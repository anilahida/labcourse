<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['logout', 'refresh', 'me']);
    }
   
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        $accessToken  = auth('api')->login($user);
        $refreshToken = $this->createRefreshToken($user);

        return response()->json([
            'success'       => true,
            'message'       => 'Regjistrim i suksesshëm.',
            'access_token'  => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type'    => 'bearer',
            'expires_in'    => config('jwt.ttl') * 60,
            'user'          => [
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'is_admin' => (bool) $user->is_admin,
            ],
        ], 201);
    }

   
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email ose fjalëkalimi është i gabuar.',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Nuk mund të krijohet token.',
            ], 500);
        }

        $user         = auth('api')->user();
        $refreshToken = $this->createRefreshToken($user);

        return response()->json([
            'success'       => true,
            'message'       => 'Hyrje e suksesshme.',
            'access_token'  => $token,
            'refresh_token' => $refreshToken,
            'token_type'    => 'bearer',
            'expires_in'    => config('jwt.ttl') * 60,
            'user'          => [
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'is_admin' => (bool) $user->is_admin,
            ],
        ]);
    }

   
    public function logout()
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token); // blacklist
            auth('api')->logout();
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token i pavlefshëm.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Dil me sukses. Token-i u invalidua dhe nuk mund të ripërdoret.',
        ]);
    }

    
    public function refresh()
    {
        try {
            // Blacklisto token-in e vjetër dhe gjenero të ri
            $newToken = auth('api')->refresh(true, true);

            return response()->json([
                'success'      => true,
                'access_token' => $newToken,
                'token_type'   => 'bearer',
                'expires_in'   => config('jwt.ttl') * 60,
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token i skaduar. Hyr përsëri.',
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token i pavlefshëm.',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gabim me token-in. Hyr përsëri.',
            ], 401);
        }
    }

    
    public function me()
    {
        $user = auth('api')->user();

        return response()->json([
            'success' => true,
            'user'    => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'is_admin'   => (bool) $user->is_admin,
                'created_at' => $user->created_at->format('d M Y'),
            ],
        ]);
    }

    /**
     * Krijo refresh token me jetëgjatësi 7 ditë
     */
    private function createRefreshToken(User $user): string
    {
        $ttl = 60 * 24 * 7; // 7 ditë në minuta
        JWTAuth::factory()->setTTL($ttl);

        return JWTAuth::customClaims(['type' => 'refresh'])->fromUser($user);
    }
}