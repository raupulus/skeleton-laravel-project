# Módulo: Panel Usuario (Filament)

*Última actualización: 2026-08-26*

> Panel de usuario en `/panel` con edición de perfil personal y gestión de tokens API propios.

---

## Objetivo y funcionalidad

El panel de usuario es un área privada destinada a todos los usuarios registrados de la plataforma, independientemente de su rol. Su objetivo es ofrecer a cada usuario un espacio propio donde pueda gestionar su información personal y sus credenciales de acceso a la API, sin necesidad de acceso al panel de administración.

El panel se construye con Filament 5 y se accede en `/panel`. Incluye dos páginas principales:

1. **Mi Perfil (EditProfile)**: permite al usuario editar su nombre, foto de avatar y contraseña. El email se muestra como campo de solo lectura para evitar cambios accidentales. Al guardar, se muestra una notificación de confirmación.

2. **Tokens API (ApiTokens)**: permite al usuario crear, listar y eliminar tokens de acceso a la API REST (Laravel Sanctum). El token generado se muestra una sola vez tras la creación. Los tokens revocados dejan de funcionar inmediatamente.

El dashboard incluye un widget de bienvenida que muestra el nombre del usuario, el número de tokens API activos y enlaces rápidos a las dos páginas del panel. El acceso solo requiere que la cuenta esté activa (`is_active = true`), sin restricción por rol.

---

## Resumen

El panel de usuario es un área privada accesible para cualquier usuario activo (independientemente de su rol). Ofrece dos páginas: edición del perfil personal (nombre, avatar, contraseña) y gestión de tokens API (listar, crear, eliminar). Incluye un widget de bienvenida en el dashboard.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Panel Provider | `app/Providers/Filament/PanelPanelProvider.php` |
| Página - Perfil | `app/Filament/Panel/Pages/EditProfile.php` |
| Página - Tokens | `app/Filament/Panel/Pages/ApiTokens.php` |
| Widget | `app/Filament/Panel/Widgets/WelcomeWidget.php` |
| Vista - Perfil | `resources/views/filament/panel/pages/edit-profile.blade.php` |
| Vista - Tokens | `resources/views/filament/panel/pages/api-tokens.blade.php` |

---

## Página: Mi Perfil (`EditProfile`)

**Ruta de menú**: Mi Perfil | **Icono**: `heroicon-o-user`

### Campos del formulario

| Campo | Tipo | Editable | Descripción |
|-------|------|:---:|-------------|
| `name` | TextInput | ✅ | Nombre del usuario |
| `email` | TextInput (email) | ❌ (disabled) | Email, solo lectura |
| `avatar` | FileUpload | ✅ | Foto de perfil, directorio `avatars` |
| `password` | TextInput (password) | ✅ | Nueva contraseña (min 8). Solo se actualiza si se rellena |

Al guardar, se muestra notificación: «Perfil actualizado correctamente.»

---

## Página: Tokens API (`ApiTokens`)

**Ruta de menú**: Tokens API | **Icono**: `heroicon-o-key`

### Funcionalidades

| Acción | Descripción |
|--------|-------------|
| **Listar** | Tabla con nombre, última vez usado, fecha de creación de cada token |
| **Crear** | Campo de nombre + botón. El token generado se muestra **una sola vez** |
| **Eliminar** | Botón por token. Revocación inmediata e irreversible |

### Propiedades Livewire

- `$tokenName` — Nombre del token a crear
- `$plainTextToken` — Token en texto plano, solo visible tras la creación (se limpia al eliminar un token)
- `tokens()` (computed `#[Computed]`) — Lista de tokens del usuario ordenados por fecha desc

### Notas de implementación

- El método `tokens()` usa el atributo `#[Computed]` de Livewire v3.
- La validación muestra un mensaje de error bajo el campo de nombre si está vacío.
- El botón "Crear" queda deshabilitado mientras se procesa la petición (`wire:loading.attr`).
- El botón "Eliminar" pide confirmación nativa mediante `wire:confirm`.
- Al pulsar Enter en el campo de nombre también se dispara la creación (`wire:keydown.enter`).
- La columna «Último uso» muestra la fecha de `last_used_at` o «—» si el token no se ha usado aún.

---

## Widget: WelcomeWidget

Muestra en el dashboard:
- Mensaje «Bienvenido, {nombre}»
- Número de tokens API activos
- Enlaces rápidos a Mi Perfil y Tokens API

---

## Acceso

Controlado por `User::canAccessPanel(Panel $panel)`:

```php
// Para el panel de usuario, solo se requiere cuenta activa
return $this->is_active;
```

Cualquier usuario (superadmin, admin, user) con `is_active = true` puede acceder.
