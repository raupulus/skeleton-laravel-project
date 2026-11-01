<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\Recaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'g-recaptcha-response' => [new Recaptcha('forgot_password')],
        ]);

        // Enviar enlace si la cuenta existe; devolver siempre estado de éxito para evitar enumeración de usuarios
        Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('status', __(Password::RESET_LINK_SENT));
    }
}
