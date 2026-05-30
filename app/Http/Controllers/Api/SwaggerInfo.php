<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     title="Libraria Ime — API",
 *     version="1.0.0",
 *     description="API e plotë për sistemin e menaxhimit të librave. Mbështet JWT Authentication me access token dhe refresh token.",
 *     @OA\Contact(
 *         email="admin@librariame.com",
 *         name="Libraria Ime Support"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Server kryesor"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Fut JWT token-in: Bearer {token}"
 * )
 *
 * @OA\Tag(name="Auth",       description="Autentifikim — regjistrim, hyrje, dalje, rifreskim")
 * @OA\Tag(name="Books",      description="Librat — listë dhe detaje")
 * @OA\Tag(name="Authors",    description="Autorët — CRUD")
 * @OA\Tag(name="Categories", description="Kategoritë — CRUD")
 * @OA\Tag(name="Orders",     description="Porositë")
 * @OA\Tag(name="Coupons",    description="Kuponat e zbritjes")
 * @OA\Tag(name="Shipments",  description="Dërgesat")
 *
 * ── Skema të ripërdorshme ──────────────────────────────────────────────
 *
 * @OA\Schema(
 *     schema="TokenResponse",
 *     @OA\Property(property="success",       type="boolean", example=true),
 *     @OA\Property(property="message",       type="string",  example="Hyrje e suksesshme."),
 *     @OA\Property(property="access_token",  type="string",  example="eyJ0eXAiOiJKV1Qi..."),
 *     @OA\Property(property="refresh_token", type="string",  example="eyJ0eXAiOiJKV1Qi..."),
 *     @OA\Property(property="token_type",    type="string",  example="bearer"),
 *     @OA\Property(property="expires_in",    type="integer", example=3600),
 *     @OA\Property(property="user",          ref="#/components/schemas/UserShort")
 * )
 *
 * @OA\Schema(
 *     schema="UserShort",
 *     @OA\Property(property="id",       type="integer", example=1),
 *     @OA\Property(property="name",     type="string",  example="Anila Hida"),
 *     @OA\Property(property="email",    type="string",  example="anila@test.com"),
 *     @OA\Property(property="is_admin", type="boolean", example=false)
 * )
 *
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string",  example="Email ose fjalëkalimi është i gabuar.")
 * )
 */
class SwaggerInfo {}
