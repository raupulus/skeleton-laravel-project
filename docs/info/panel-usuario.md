# Módulo: Panel Usuario (Filament)

> Panel de usuario en `/panel` con edición de perfil personal y gestión de tokens API propios.

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
