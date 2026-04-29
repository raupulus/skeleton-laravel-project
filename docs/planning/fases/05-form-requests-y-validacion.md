# Fase 05 — Form Requests y validación

## Resumen
En esta fase se crearán todos los FormRequests con reglas de validación completas y mensajes en español para las operaciones de escritura de la API y el frontend web.

**Dependencias**: Fases 01-04 completadas.

---

## Paso 5.1 — FormRequests de autenticación API

### `RegisterRequest`

Archivo: `app/Http/Requests/Api/V1/Auth/RegisterRequest.php`

```php
<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para el registro de usuarios vía API.
 */
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
```

### `LoginRequest`

Archivo: `app/Http/Requests/Api/V1/Auth/LoginRequest.php`

```php
<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para el inicio de sesión vía API.
 */
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ];
    }
}
```

### `ForgotPasswordRequest`

Archivo: `app/Http/Requests/Api/V1/Auth/ForgotPasswordRequest.php`

```php
<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para solicitar restablecimiento de contraseña.
 */
class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'email.exists' => 'No encontramos un usuario con ese correo electrónico.',
        ];
    }
}
```

### `ResetPasswordRequest`

Archivo: `app/Http/Requests/Api/V1/Auth/ResetPasswordRequest.php`

```php
<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para restablecer la contraseña con token.
 */
class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => 'El token es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
```

---

## Paso 5.2 — FormRequest de contacto web

Archivo: `app/Http/Requests/Web/ContactRequest.php`

```php
<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para el formulario de contacto del frontend.
 */
class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'privacy' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'subject.required' => 'El asunto es obligatorio.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.max' => 'El mensaje no puede superar los :max caracteres.',
            'privacy.required' => 'Debes aceptar la política de privacidad.',
            'privacy.accepted' => 'Debes aceptar la política de privacidad.',
        ];
    }
}
```

---

## Paso 5.3 — FormRequest para tokens API (Panel Usuario)

Archivo: `app/Http/Requests/Api/V1/TokenCreateRequest.php`

```php
<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para crear un nuevo token API personal.
 */
class TokenCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // El usuario autenticado puede crear tokens para sí mismo
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del token es obligatorio.',
        ];
    }
}
```

---

## Checklist de verificación

- [ ] `RegisterRequest` creado con validación de name, email (unique), password (confirmed, min:8)
- [ ] `LoginRequest` creado con validación de email y password
- [ ] `ForgotPasswordRequest` creado con validación de email (exists)
- [ ] `ResetPasswordRequest` creado con validación de token, email, password
- [ ] `ContactRequest` creado con validación de name, email, subject, message, privacy
- [ ] `TokenCreateRequest` creado con validación de name
- [ ] Todos los mensajes de validación en español
- [ ] Todos los FormRequests con `authorize()` definido
