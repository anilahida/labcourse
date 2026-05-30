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
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Auth"},
     *     summary="Regjistro përdorues të ri",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *             @OA\Property(property="name",                  type="string",  example="Anila Hida"),
     *             @OA\Property(property="email",                 type="string",  example="anila@test.com"),
     *             @OA\Property(property="password",              type="string",  example="secret123"),
     *             @OA\Property(property="password_confirmation", type="string",  example="secret123")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Regjistrim i suksesshëm", @OA\JsonContent(ref="#/components/schemas/TokenResponse")),
     *     @OA\Response(response=422, description="Validim dështoi",         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"))
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Hyr me email dhe fjalëkalim",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email",    type="string", example="admin@test.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Hyrje e suksesshme",           @OA\JsonContent(ref="#/components/schemas/TokenResponse")),
     *     @OA\Response(response=401, description="Kredenciale të gabuara",        @OA\JsonContent(ref="#/components/schemas/ErrorResponse"))
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     summary="Dil dhe invalido token-in (blacklist)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Logout i suksesshëm",   @OA\JsonContent(@OA\Property(property="success",type="boolean",example=true),@OA\Property(property="message",type="string",example="Token-i u invalidua."))),
     *     @OA\Response(response=401, description="Token i pavlefshëm",    @OA\JsonContent(ref="#/components/schemas/ErrorResponse"))
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     tags={"Auth"},
     *     summary="Rifresko access token (blackliston token-in e vjetër)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Token i ri",         @OA\JsonContent(@OA\Property(property="success",type="boolean",example=true),@OA\Property(property="access_token",type="string",example="eyJ0eXAi..."),@OA\Property(property="expires_in",type="integer",example=3600))),
     *     @OA\Response(response=401, description="Token i skaduar",    @OA\JsonContent(ref="#/components/schemas/ErrorResponse"))
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/auth/me",
     *     tags={"Auth"},
     *     summary="Merr profilin e përdoruesit të kyçur",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Profili i përdoruesit", @OA\JsonContent(@OA\Property(property="success",type="boolean",example=true),@OA\Property(property="user",ref="#/components/schemas/UserShort"))),
     *     @OA\Response(response=401, description="Pa autentifikim",       @OA\JsonContent(ref="#/components/schemas/ErrorResponse"))
     * )
     */
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