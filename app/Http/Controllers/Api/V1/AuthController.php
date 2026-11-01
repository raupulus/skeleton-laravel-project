<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Requests\Api\V1\Auth\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

/**
 * Controlador de autenticación para la API v1.
 * Gestiona registro, login, logout, perfil y recuperación de contraseña.
 *
 * @group Autenticación
 */
class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario en la plataforma y devuelve su token de acceso.
     * Envía un email de bienvenida tras el registro exitoso.
     *
     * @unauthenticated
     *
     * @param  RegisterRequest  $request  Datos validados del registro
     * @param  EmailService  $emailService  Servicio para envío de emails
     * @return JsonResponse Usuario creado y token de acceso
     */
    public function register(RegisterRequest $request, EmailService $emailService): JsonResponse
    {
        [$user, $token] = DB::transaction(function () use ($request) {
            // Crear el usuario — el cast 'hashed' en el modelo User se encarga de hashear la contraseña
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Generar token de acceso personal para el nuevo usuario
            $token = $user->createToken('api-token')->plainTextToken;

            return [$user, $token];
        });

        // Enviar email de bienvenida y registrarlo en sent_emails fuera de la transacción de BD
        $emailService->send(new WelcomeMail($user), $user->email, __('messages.welcome_subject'));

        return response()->json([
            'message' => __('messages.api_registered'),
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    /**
     * Autentica al usuario con sus credenciales y devuelve un token de acceso.
     * Verifica también que el usuario esté activo en la plataforma.
     *
     * @unauthenticated
     *
     * @param  LoginRequest  $request  Credenciales de acceso validadas
     * @return JsonResponse Token de acceso o error de autenticación
     *
     * @throws ValidationException Si las credenciales son incorrectas
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Buscar usuario por email normalizado
        $user = User::where('email', mb_strtolower(trim($request->email)))->first();

        // Verificar existencia del usuario y validez de la contraseña
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        // Verificar que el usuario está activo en la plataforma
        if (! $user->is_active) {
            return response()->json(['message' => __('messages.account_deactivated')], 403);
        }

        return response()->json([
            'message' => __('messages.api_logged_in'),
            'user' => new UserResource($user),
            'token' => $user->createToken('api-token')->plainTextToken,
        ]);
    }

    /**
     * Revoca el token de acceso actual del usuario autenticado.
     *
     * @authenticated
     *
     * @param  Request  $request  La petición HTTP con el usuario autenticado
     * @return JsonResponse Confirmación de cierre de sesión
     */
    public function logout(Request $request): JsonResponse
    {
        // Revocar únicamente el token actual (no todos los tokens del usuario)
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => __('messages.api_logged_out')]);
    }

    /**
     * Devuelve los datos del usuario autenticado actualmente.
     *
     * @authenticated
     *
     * @param  Request  $request  La petición HTTP con el usuario autenticado
     * @return JsonResponse Datos del usuario autenticado
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json(new UserResource($request->user()));
    }

    /**
     * Envía un enlace de restablecimiento de contraseña al email especificado.
     * Devuelve siempre una respuesta genérica 200 para evitar enumeración de usuarios (OWASP).
     *
     * @unauthenticated
     *
     * @param  ForgotPasswordRequest  $request  Email validado del usuario
     * @return JsonResponse Confirmación genérica de envío
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        // Enviar el enlace de restablecimiento si el usuario existe
        Password::sendResetLink($request->only('email'));

        return response()->json([
            'message' => __(Password::RESET_LINK_SENT),
        ]);
    }

    /**
     * Restablece la contraseña del usuario usando el token de restablecimiento.
     *
     * @unauthenticated
     *
     * @param  ResetPasswordRequest  $request  Datos validados del restablecimiento
     * @return JsonResponse Confirmación del restablecimiento o error
     *
     * @throws ValidationException Si el token es inválido o ha expirado
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        // Ejecutar el restablecimiento usando el broker de passwords de Laravel
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                // El cast 'hashed' en el modelo se encarga de hashear la contraseña
                $user->forceFill(['password' => $password])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)]);
        }

        throw ValidationException::withMessages(['email' => [__($status)]]);
    }
}
