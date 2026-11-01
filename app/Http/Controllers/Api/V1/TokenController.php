<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TokenCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de tokens de API personales.
 * Cada usuario solo puede ver y gestionar sus propios tokens.
 *
 * @group Tokens de API
 *
 * @authenticated
 */
class TokenController extends Controller
{
    /**
     * Lista todos los tokens de API del usuario autenticado.
     * Los tokens se ordenan del más reciente al más antiguo.
     *
     * @param  Request  $request  La petición con el usuario autenticado
     * @return JsonResponse Colección de tokens del usuario
     */
    public function index(Request $request): JsonResponse
    {
        $tokens = $request->user()->tokens()->orderByDesc('created_at')->get();

        return response()->json($tokens);
    }

    /**
     * Crea un nuevo token de API para el usuario autenticado.
     * El token en texto plano solo se devuelve en esta respuesta, no se puede recuperar después.
     *
     * @param  TokenCreateRequest  $request  Datos validados con el nombre del token
     * @return JsonResponse Token creado con su valor en texto plano
     */
    public function store(TokenCreateRequest $request): JsonResponse
    {
        // Crear el token y obtener el valor en texto plano (solo visible en este momento)
        $token = $request->user()->createToken($request->name);

        return response()->json([
            'message' => 'Token creado correctamente. Guárdalo ahora, no se mostrará de nuevo.',
            'token' => $token->plainTextToken,
            'name' => $request->name,
        ], 201);
    }

    /**
     * Elimina un token de API específico del usuario autenticado.
     * Solo se puede eliminar un token propio, no de otros usuarios.
     *
     * @param  Request  $request  La petición con el usuario autenticado
     * @param  int  $tokenId  El ID del token a eliminar
     * @return JsonResponse Confirmación de la eliminación
     */
    public function destroy(Request $request, int $tokenId): JsonResponse
    {
        // Buscar el token entre los del usuario autenticado (seguridad)
        $token = $request->user()->tokens()->find($tokenId);

        if (! $token) {
            return response()->json(['message' => 'Token no encontrado.'], 404);
        }

        $token->delete();

        return response()->json(['message' => 'Token eliminado correctamente.']);
    }
}
