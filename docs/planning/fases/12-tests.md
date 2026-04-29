# Fase 12 — Tests

## Resumen
En esta fase se crearán tests unitarios y feature tests para los módulos críticos: autenticación web y API, autorización (policies), servicios (EmailService, SettingService) y flujos completos.

**Dependencias**: Fases 01-11 completadas.

---

## Paso 12.1 — Configurar entorno de testing

Archivo: `phpunit.xml` — Verificar que usa SQLite en memoria o PostgreSQL de test:

```xml
<env name="DB_CONNECTION" value="pgsql"/>
<env name="DB_DATABASE" value="skeleton_laravel_test"/>
```

O si se prefiere SQLite para tests rápidos:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

Archivo: `.env.testing`:

```env
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
MAIL_MAILER=array
QUEUE_CONNECTION=sync
CACHE_DRIVER=array
```

---

## Paso 12.2 — Tests de autenticación web

Archivo: `tests/Feature/Auth/RegistrationTest.php`

```php
<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }
}
```

Archivo: `tests/Feature/Auth/LoginTest.php`

```php
<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_users_can_authenticate(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
```

Archivo: `tests/Feature/Auth/PasswordResetTest.php`

```php
// Tests para:
// - test_reset_password_link_screen_can_be_rendered
// - test_reset_password_link_can_be_requested
// - test_password_can_be_reset_with_valid_token
```

Archivo: `tests/Feature/Auth/EmailVerificationTest.php`

```php
// Tests para:
// - test_email_verification_screen_can_be_rendered
// - test_email_can_be_verified
// - test_email_is_not_verified_with_invalid_hash
```

---

## Paso 12.3 — Tests de autenticación API

Archivo: `tests/Feature/Api/AuthApiTest.php`

```php
<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_via_api(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'user', 'token']);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login_via_api(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk()
                 ->assertJsonStructure(['message', 'user', 'token']);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_logout_via_api(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
                         ->postJson('/api/v1/auth/logout');

        $response->assertOk();
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_user_can_get_own_profile(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
                         ->getJson('/api/v1/auth/user');

        $response->assertOk()
                 ->assertJsonFragment(['email' => $user->email]);
    }

    public function test_unauthenticated_user_cannot_access_protected_routes(): void
    {
        $response = $this->getJson('/api/v1/auth/user');
        $response->assertStatus(401);
    }

    public function test_user_can_request_password_reset(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/auth/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertOk();
    }
}
```

---

## Paso 12.4 — Tests de API de tokens

Archivo: `tests/Feature/Api/TokenApiTest.php`

```php
// Tests para:
// - test_user_can_list_own_tokens
// - test_user_can_create_token
// - test_user_can_delete_own_token
// - test_created_token_is_returned_once
```

---

## Paso 12.5 — Tests de autorización (Policies)

Archivo: `tests/Feature/Auth/AuthorizationTest.php`

```php
<?php

namespace Tests\Feature\Auth;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_panel(): void
    {
        $admin = User::factory()->create(['role' => Role::SuperAdmin]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
    }

    public function test_normal_user_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create(['role' => Role::User]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_normal_user_can_access_user_panel(): void
    {
        $user = User::factory()->create(['role' => Role::User]);

        $response = $this->actingAs($user)->get('/panel');

        $response->assertStatus(200);
    }
}
```

---

## Paso 12.6 — Tests de EmailService

Archivo: `tests/Unit/Services/EmailServiceTest.php`

```php
<?php

namespace Tests\Unit\Services;

use App\Enums\EmailStatus;
use App\Mail\GenericMail;
use App\Models\SentEmail;
use App\Services\EmailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_is_sent_and_recorded(): void
    {
        Mail::fake();

        $service = app(EmailService::class);
        $mailable = new GenericMail('Test Subject', '<p>Test content</p>');

        $record = $service->send($mailable, 'test@example.com', 'Test Subject');

        $this->assertInstanceOf(SentEmail::class, $record);
        $this->assertEquals('test@example.com', $record->to);
        $this->assertEquals(EmailStatus::Sent, $record->status);
        $this->assertDatabaseHas('sent_emails', ['to' => 'test@example.com']);
    }

    public function test_failed_email_is_recorded_with_error(): void
    {
        Mail::shouldReceive('to->send')->andThrow(new \Exception('SMTP error'));

        $service = app(EmailService::class);
        $mailable = new GenericMail('Test', '<p>Content</p>');

        $record = $service->send($mailable, 'test@example.com', 'Test');

        $this->assertEquals(EmailStatus::Failed, $record->status);
        $this->assertNotNull($record->error_message);
    }
}
```

---

## Paso 12.7 — Tests de SettingService

Archivo: `tests/Unit/Services/SettingServiceTest.php`

```php
<?php

namespace Tests\Unit\Services;

use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_returns_correct_value(): void
    {
        Setting::create([
            'key' => 'test_key',
            'display_name' => 'Test',
            'value' => 'test_value',
            'type' => 'text',
            'group' => 'general',
        ]);

        $service = app(SettingService::class);
        $service->clearCache();

        $this->assertEquals('test_value', $service->get('test_key'));
    }

    public function test_setting_returns_default_when_not_found(): void
    {
        $service = app(SettingService::class);
        $service->clearCache();

        $this->assertEquals('default', $service->get('nonexistent', 'default'));
    }

    public function test_setting_helper_function_works(): void
    {
        Setting::create([
            'key' => 'helper_test',
            'display_name' => 'Helper Test',
            'value' => 'works',
            'type' => 'text',
            'group' => 'general',
        ]);

        app(SettingService::class)->clearCache();

        $this->assertEquals('works', setting('helper_test'));
    }
}
```

---

## Paso 12.8 — Tests de rutas web públicas

Archivo: `tests/Feature/Web/PublicRoutesTest.php`

```php
<?php

namespace Tests\Feature\Web;

use App\Models\Post;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_is_accessible(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_blog_page_is_accessible(): void
    {
        $this->get('/blog')->assertStatus(200);
    }

    public function test_about_page_is_accessible(): void
    {
        $this->get('/about')->assertStatus(200);
    }

    public function test_contact_page_is_accessible(): void
    {
        $this->get('/contact')->assertStatus(200);
    }

    public function test_published_post_is_accessible(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'slug' => 'test-post',
            'status' => 'published',
            'is_active' => true,
            'user_id' => $user->id,
        ]);

        $this->get('/blog/test-post')->assertStatus(200);
    }

    public function test_draft_post_returns_404(): void
    {
        $user = User::factory()->create();
        Post::factory()->create([
            'slug' => 'draft-post',
            'status' => 'draft',
            'user_id' => $user->id,
        ]);

        $this->get('/blog/draft-post')->assertStatus(404);
    }

    public function test_contact_form_can_be_submitted(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content',
            'privacy' => true,
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');
    }
}
```

---

## Paso 12.9 — Tests de Mailables

Archivo: `tests/Unit/Mail/ContactMailTest.php`

```php
<?php

namespace Tests\Unit\Mail;

use App\Mail\ContactMail;
use Tests\TestCase;

class ContactMailTest extends TestCase
{
    public function test_contact_mail_has_correct_content(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Hello world',
        ];

        $mail = new ContactMail($data);

        $mail->assertHasSubject('Nuevo mensaje de contacto: Test Subject');
        $mail->assertSeeInHtml('Test User');
        $mail->assertSeeInHtml('test@example.com');
    }
}
```

---

## Paso 12.10 — Ejecutar tests

```bash
php artisan test
```

O con detalle:

```bash
php artisan test --verbose
```

---

## Checklist de verificación

- [ ] `.env.testing` configurado con SQLite en memoria
- [ ] Tests de registro web: pantalla, registro exitoso
- [ ] Tests de login web: pantalla, login exitoso, login fallido, logout
- [ ] Tests de password reset web: pantalla, solicitud, reset con token
- [ ] Tests de verificación de email web
- [ ] Tests de API: register, login, login fallido, logout, get user, acceso no autenticado, forgot-password
- [ ] Tests de tokens API: listar, crear, eliminar
- [ ] Tests de autorización: admin accede a /admin, user no accede a /admin, user accede a /panel
- [ ] Tests de EmailService: envío exitoso registrado, envío fallido registrado con error
- [ ] Tests de SettingService: obtener valor, valor por defecto, helper `setting()` funcional
- [ ] Tests de rutas públicas: home, blog, about, contact, post publicado, post borrador 404
- [ ] Tests de formulario de contacto: envío exitoso
- [ ] Tests de Mailables: contenido correcto
- [ ] `php artisan test` ejecutado sin errores
