# Fase 09 — Panel Filament (backoffice)

## Resumen
En esta fase se crearán todos los Resources, Pages personalizadas, Widgets y Navigation Groups para los dos paneles Filament: Admin (`/admin`) y Usuario (`/panel`).

**Dependencias**: Fases 01-08 completadas.

---

## Paso 9.1 — Panel Admin: `UserResource`

Archivo: `app/Filament/Admin/Resources/UserResource.php`

CRUD completo de usuarios con:

**Tabla (list)**:
- Columnas: `name`, `email`, `role` (badge con color), `is_active` (icono boolean), `created_at`
- Filtros: por `role` (select), por `is_active` (ternary)
- Búsqueda: por `name`, `email`
- Acciones en lote: eliminar

**Formulario (create/edit)**:
- `name` — TextInput, required, max:255
- `email` — TextInput, email, required, unique (ignorar actual en update)
- `password` — TextInput, password, required solo en create, min:8
- `role` — Select con opciones del enum `Role`
- `avatar` — FileUpload, image, directory 'avatars'
- `is_active` — Toggle, default true

**Policy**: `UserPolicy` (solo admin puede acceder)

```php
// Estructura del Resource
class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form { /* campos descritos arriba */ }
    public static function table(Table $table): Table { /* columnas y filtros descritos arriba */ }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
```

Crear también las Pages del Resource: `ListUsers`, `CreateUser`, `EditUser`.

---

## Paso 9.2 — Panel Admin: `PageResource`

Archivo: `app/Filament/Admin/Resources/PageResource.php`

CRUD de páginas con traducciones.

**Formulario** con Tabs por idioma:

```php
use Filament\Forms\Components\Tabs;

public static function form(Form $form): Form
{
    return $form->schema([
        Tabs::make('Traducciones')->tabs([
            Tabs\Tab::make('Español')->schema([
                TextInput::make('title.es')->label('Título (ES)')->required(),
                RichEditor::make('content.es')->label('Contenido (ES)'),
                Textarea::make('excerpt.es')->label('Extracto (ES)'),
                TextInput::make('seo_title.es')->label('SEO Título (ES)'),
                Textarea::make('seo_description.es')->label('SEO Descripción (ES)'),
                TextInput::make('seo_keywords.es')->label('SEO Keywords (ES)'),
            ]),
            Tabs\Tab::make('English')->schema([
                TextInput::make('title.en')->label('Title (EN)'),
                RichEditor::make('content.en')->label('Content (EN)'),
                Textarea::make('excerpt.en')->label('Excerpt (EN)'),
                TextInput::make('seo_title.en')->label('SEO Title (EN)'),
                Textarea::make('seo_description.en')->label('SEO Description (EN)'),
                TextInput::make('seo_keywords.en')->label('SEO Keywords (EN)'),
            ]),
        ])->columnSpanFull(),

        TextInput::make('slug')->label('Slug')->unique(ignoreRecord: true),
        FileUpload::make('image')->label('Imagen')->image()->directory('pages'),
        Select::make('status')->label('Estado')
            ->options(ContentStatus::class)->default('draft'),
        Toggle::make('featured')->label('Destacado'),
        Toggle::make('is_active')->label('Activo')->default(true),
        Select::make('categories')->label('Categorías')
            ->relationship('categories', 'name->es')
            ->multiple()->preload(),
        DateTimePicker::make('published_at')->label('Fecha de publicación'),
    ]);
}
```

**Tabla**: slug, título (locale actual), status (badge), featured (icon), categories, user, published_at
**Filtros**: status, featured, category
**Navigation Group**: "Contenido"

---

## Paso 9.3 — Panel Admin: `PostResource`

Archivo: `app/Filament/Admin/Resources/PostResource.php`

Misma estructura que `PageResource` con las mismas tabs de traducción, mismos campos.
Diferencia: incluye `published_at` como campo prominente.

**Navigation Group**: "Contenido"

---

## Paso 9.4 — Panel Admin: `CategoryResource`

Archivo: `app/Filament/Admin/Resources/CategoryResource.php`

**Formulario**:
- Tabs de traducción para `name` y `description` (es/en)
- `slug` — TextInput, unique
- `image` — FileUpload
- `is_active` — Toggle
- `order` — TextInput numeric

**Tabla**: slug, name, is_active, order, posts_count, pages_count
**Navigation Group**: "Contenido"

---

## Paso 9.5 — Panel Admin: `SlideResource`

Archivo: `app/Filament/Admin/Resources/SlideResource.php`

**Formulario**:
- Tabs de traducción para `title` y `content` (es/en)
- `image` — FileUpload, required, image, con recorte (crop). Implementar recorte 16:9 usando Filament Cropper o configuración de imageCropAspectRatio:

```php
FileUpload::make('image')
    ->label('Imagen (16:9)')
    ->image()
    ->required()
    ->imageEditor()
    ->imageEditorAspectRatios(['16:9'])
    ->directory('slides'),

FileUpload::make('image_vertical')
    ->label('Imagen Vertical (8:12)')
    ->image()
    ->imageEditor()
    ->imageEditorAspectRatios(['8:12'])
    ->directory('slides'),
```

- `url` — TextInput, url, nullable
- `zone` — TextInput (o Select con opciones dinámicas basadas en zones existentes)
- `order` — TextInput numeric
- `is_active` — Toggle

**Tabla**: image (thumbnail), title, zone, order, is_active. Agrupado por zone.
**Filtros**: zone, is_active
**Navigation Group**: "Media"

---

## Paso 9.6 — Panel Admin: `SectionResource`

Archivo: `app/Filament/Admin/Resources/SectionResource.php`

**Formulario**:
- Tabs de traducción para `title`, `description`, `content` (es/en)
- `content` usa RichEditor
- `slug` — TextInput, unique
- `zone` — TextInput o Select
- `image` — FileUpload
- `order` — TextInput numeric

**Tabla**: slug, zone, title, order. Agrupado visualmente por zone.
**Filtros**: zone
**Navigation Group**: "Frontend"

---

## Paso 9.7 — Panel Admin: `SettingResource`

Archivo: `app/Filament/Admin/Resources/SettingResource.php`

**Formulario**:
- `key` — TextInput, required, unique
- `display_name` — TextInput, required
- `value` — El tipo de campo depende del valor de `type` (texto, textarea, imagen, etc.). Se puede usar un componente dinámico o simplemente Textarea para mantenerlo simple.
- `details` — Textarea
- `type` — Select con opciones: text, textarea, image, select, checkbox, radio, number
- `order` — TextInput numeric
- `group` — Select o TextInput (general, seo, social, contact)

**Tabla**: key, display_name, value (truncado), type, group, order. Agrupado por group.
**Filtros**: group, type

**IMPORTANTE**: Al guardar/actualizar un setting, limpiar la caché:

```php
// En la página CreateSetting y EditSetting:
protected function afterSave(): void
{
    app(\App\Services\SettingService::class)->clearCache();
}
```

**Navigation Group**: "Sistema"

---

## Paso 9.8 — Panel Admin: `SentEmailResource`

Archivo: `app/Filament/Admin/Resources/SentEmailResource.php`

**Solo lectura** — sin crear ni editar.

**Tabla**: to, subject, mailable_class, status (badge), created_at
**Filtros**: status, rango de fechas
**Acción**: ViewAction para ver el body completo del email en un modal

```php
public static function canCreate(): bool
{
    return false;
}

// En la tabla, acción para ver detalle:
Tables\Actions\ViewAction::make(),
```

**Navigation Group**: "Sistema"

---

## Paso 9.9 — Panel Admin: Dashboard Widgets

Crear widgets en `app/Filament/Admin/Widgets/`:

### `StatsOverviewWidget`

```php
// Muestra tarjetas con:
// - Total de usuarios activos
// - Total de posts publicados
// - Total de páginas publicadas
// - Total de emails enviados
```

### `LatestEmailsWidget`

```php
// Tabla con los últimos 5 emails enviados (to, subject, status, created_at)
```

### `PostsChartWidget`

```php
// Gráfico de barras con posts creados por mes (últimos 6 meses)
```

---

## Paso 9.10 — Panel Admin: Navigation Groups

Configurar en el `AdminPanelProvider` o en cada Resource:

```
- Contenido
  - Páginas
  - Posts
  - Categorías
- Media
  - Slides
- Frontend
  - Secciones
- Sistema
  - Usuarios
  - Configuración
  - Emails Enviados
```

---

## Paso 9.11 — Panel Usuario: `EditProfile` Page

Archivo: `app/Filament/Panel/Pages/EditProfile.php`

Page personalizada para editar el perfil del usuario autenticado:

```php
<?php

namespace App\Filament\Panel\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;

class EditProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $title = 'Mi Perfil';
    protected static ?string $navigationLabel = 'Mi Perfil';
    protected static string $view = 'filament.panel.pages.edit-profile';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(auth()->user()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('Nombre')->required(),
            TextInput::make('email')->label('Email')->email()->required()->disabled(),
            FileUpload::make('avatar')->label('Avatar')->image()->directory('avatars'),
            TextInput::make('password')->label('Nueva contraseña')->password()
                ->minLength(8)->confirmed()->dehydrated(fn ($state) => filled($state)),
            TextInput::make('password_confirmation')->label('Confirmar contraseña')->password(),
        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();

        $user->name = $data['name'];
        if (!empty($data['avatar'])) {
            $user->avatar = $data['avatar'];
        }
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        $this->notify('success', 'Perfil actualizado correctamente.');
    }
}
```

Crear vista: `resources/views/filament/panel/pages/edit-profile.blade.php`

---

## Paso 9.12 — Panel Usuario: `ApiTokens` Page

Archivo: `app/Filament/Panel/Pages/ApiTokens.php`

Page personalizada para gestionar tokens API personales:

- Listado de tokens del usuario (nombre, última vez usado, fecha de creación)
- Formulario para crear nuevo token (input de nombre + botón crear)
- Al crear, mostrar el token generado UNA SOLA VEZ en un modal/notification
- Botón eliminar por cada token
- Usa Livewire para interactividad

```php
class ApiTokens extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $title = 'Tokens de API';
    protected static ?string $navigationLabel = 'Tokens API';
    protected static string $view = 'filament.panel.pages.api-tokens';

    public string $tokenName = '';
    public ?string $plainTextToken = null;

    public function createToken(): void
    {
        $this->validate(['tokenName' => 'required|string|max:255']);
        $token = auth()->user()->createToken($this->tokenName);
        $this->plainTextToken = $token->plainTextToken;
        $this->tokenName = '';
        $this->notify('success', 'Token creado. ¡Cópialo ahora, no se mostrará de nuevo!');
    }

    public function deleteToken(int $tokenId): void
    {
        auth()->user()->tokens()->where('id', $tokenId)->delete();
        $this->notify('success', 'Token eliminado correctamente.');
    }

    public function getTokensProperty()
    {
        return auth()->user()->tokens()->orderByDesc('created_at')->get();
    }
}
```

Crear vista: `resources/views/filament/panel/pages/api-tokens.blade.php` con tabla de tokens y formulario.

---

## Paso 9.13 — Panel Usuario: Dashboard Widget

Archivo: `app/Filament/Panel/Widgets/WelcomeWidget.php`

```php
// Widget de bienvenida con:
// - "Bienvenido, {nombre del usuario}"
// - Número de tokens API activos
// - Enlace rápido a "Mi Perfil" y "Tokens API"
```

---

## Checklist de verificación

- [ ] `UserResource` con CRUD completo, filtros por role/is_active, policy aplicada
- [ ] `PageResource` con tabs de traducción es/en, campos SEO, slug auto, categorías
- [ ] `PostResource` con misma estructura que PageResource + published_at
- [ ] `CategoryResource` con traducciones, slug, order
- [ ] `SlideResource` con recorte de imagen 16:9 y 8:12, agrupado por zone
- [ ] `SectionResource` con traducciones, zone, RichEditor, agrupado por zone
- [ ] `SettingResource` con agrupación por group, limpieza de caché al guardar
- [ ] `SentEmailResource` solo lectura, con vista de body en modal
- [ ] Dashboard widgets Admin: StatsOverview, LatestEmails, PostsChart
- [ ] Navigation Groups configurados: Contenido, Media, Frontend, Sistema
- [ ] Panel Usuario: EditProfile page con editar nombre, avatar, contraseña
- [ ] Panel Usuario: ApiTokens page con listar, crear (token visible una vez), eliminar
- [ ] Panel Usuario: WelcomeWidget en dashboard
- [ ] Todas las vistas personalizadas de Filament creadas
