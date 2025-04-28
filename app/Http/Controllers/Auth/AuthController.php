<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Autenticação"},
     *     summary="Realiza login e retorna o token de acesso",
     *     description="Autentica o usuário e retorna um token de acesso válido por 5 minutos",
     *     operationId="authLogin",
     *     security={},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Credenciais de acesso",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="senha")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|abcdef123456"),
     *             @OA\Property(property="expires_at", type="string", format="date-time", example="2023-12-31 23:59:59")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Credenciais inválidas")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validação falhou",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="O campo email é obrigatório."),
     *             @OA\Property(property="errors", type="object", example={"email": {"O campo email é obrigatório."}})
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        $token = $request->user()->createToken('API Token');
        
        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => Carbon::now()->addMinutes(5)->toDateTimeString()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Autenticação"},
     *     summary="Faz logout e revoga o token atual",
     *     description="Revoga o token de acesso atual do usuário",
     *     operationId="authLogout",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout realizado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     tags={"Autenticação"},
     *     summary="Renova o token de acesso",
     *     description="Renova o token de acesso antes que expire (5 minutos de validade). Requer autenticação.",
     *     operationId="refreshToken",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="force",
     *                     type="boolean",
     *                     example=false,
     *                     description="Forçar renovação mesmo com token válido"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token renovado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="2|ghijk789012"),
     *             @OA\Property(property="expires_at", type="string", format="date-time", example="2025-04-30 15:30:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function refreshToken(Request $request)
    {
        // Revoga o token atual
        $request->user()->currentAccessToken()->delete();
        
        // Cria um novo token
        $token = $request->user()->createToken('API Token');
        
        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => Carbon::now()->addMinutes(5)->toDateTimeString()
        ]);
    }
}