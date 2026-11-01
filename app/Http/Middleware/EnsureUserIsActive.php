<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar que el usuario autenticado permanece activo.
 * Si un administrador desactiva o elimina su cuenta mientras tiene sesión o token activo,
 * se invalida inmediatamente el acceso devolviendo 403 o redirigiendo al login.
 */
class EnsureUserIsActive
{
    /**
     * Comprueba el estado activo del usuario autenticado.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && (! $user->is_active || $user->trashed())) {
            if ($request->expectsJson() || $request->is('api/*')) {
                $user->currentAccessToken()?->delete();

                return response()->json([
                    'message' => __('messages.account_deactivated'),
                ], 403);
            }

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => __('messages.account_deactivated'),
            ]);
        }

        return $next($request);
    }
}
