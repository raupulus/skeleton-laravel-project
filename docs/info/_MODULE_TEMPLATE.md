# Plantilla Oficial de Documentación de Módulos

*Última actualización: 2026-08-26*

> Esta plantilla es el estándar oficial obligatorio para documentar cualquier módulo nuevo o existente en `docs/info/[nombre-modulo].md`.
> Mantén la estructura de 7 puntos, usando descripciones concisas y tablas limpias para optimizar la comprensión humana y el consumo de tokens por agentes de IA.

---

## 1. Resumen del Módulo

[Descripción concisa de 1 a 3 frases explicando la responsabilidad de negocio del módulo, su propósito en la plataforma y si interactúa con el frontend público, intranet administrativa o API REST].

*Ejemplo: El módulo de Noticias gestiona los comunicados de prensa y artículos de actualidad de la empresa. Permite la publicación multilingüe programada desde el panel administrativo Filament y expone endpoints de consulta tanto en la web pública como en la API REST v1.*

---

## 2. Archivos Principales Involucrados

| Capa / Tipo | Ruta del Archivo | Responsabilidad Principal |
|-------------|------------------|---------------------------|
| **Modelo** | `app/Models/[Modelo].php` | Definición de tabla, `$translatable`, `$casts`, scopes y relaciones Eloquent |
| **Migración** | `database/migrations/YYYY_MM_DD_HHMMSS_create_[tabla]_table.php` | Esquema de tabla e índices con comentarios 100% en español |
| **Factory** | `database/factories/[Modelo]Factory.php` | Factoría para tests con estados (`published`, `featured`, `inactive`) |
| **Seeder** | `database/seeders/[Modelo]Seeder.php` | Datos corporativos de demostración |
| **Filament Resource** | `app/Filament/Admin/Resources/[Modelo]Resource.php` | Definición del recurso, navegación, iconos y configuración de formulario/tabla |
| **Filament Pages** | `app/Filament/Admin/Resources/[Modelo]Resource/Pages/` | Clases `List[Modelo]`, `Create[Modelo]`, `Edit[Modelo]` |
| **Policy** | `app/Policies/[Modelo]Policy.php` | Reglas de autorización según roles (`superadmin`, `admin`, `user`) |
| **Controlador Web** | `app/Http/Controllers/Web/[Modelo]Controller.php` | Renderizado de vistas públicas (`index`, `show`) y SEO |
| **Controlador API** | `app/Http/Controllers/Api/V1/[Modelo]ApiController.php` | Endpoints REST públicos/autenticados con API Resources |
| **Form Request** | `app/Http/Requests/Web/[Modelo]Request.php` | Reglas de validación, rate limiting y reCAPTCHA si aplica |
| **Vistas Blade** | `resources/views/[modulo]/` | Plantillas `index.blade.php`, `show.blade.php` con Tailwind CSS v4 |
| **Test Feature** | `tests/Feature/[Modulo]/[Modelo]Test.php` | Tests de rutas, autenticación, formulario y permisos |

---

## 3. Esquema de Base de Datos

**Tabla**: `[nombre_tabla]`

| Campo | Tipo | Nullable | Default | Descripción |
|-------|------|:--------:|:-------:|-------------|
| `id` | `bigint unsigned` | No | Auto-increment | Clave primaria |
| `slug` | `string(255)` | No | — | Slug único indexado para URLs amigables |
| `title` | `jsonb` / `json` | No | — | Título del registro traducible (`es`, `en`) |
| `content` | `jsonb` / `json` | Sí | `NULL` | Contenido principal o bloques modulares traducibles |
| `image` | `string(512)` | Sí | `NULL` | Ruta relativa del archivo de imagen en disco público |
| `status` | `string(20)` | No | `'draft'` | Estado de publicación (`draft`, `published`) |
| `is_active` | `boolean` | No | `true` | Indicador de visibilidad global |
| `order` | `integer` | No | `0` | Orden de visualización en listados |
| `user_id` | `bigint unsigned` | No | — | Clave foránea al usuario autor (`cascadeOnDelete`) |
| `published_at` | `timestamp` | Sí | `NULL` | Fecha programada de publicación |
| `created_at` | `timestamp` | Sí | `NULL` | Fecha de creación del registro |
| `updated_at` | `timestamp` | Sí | `NULL` | Fecha de última modificación |
| `deleted_at` | `timestamp` | Sí | `NULL` | Fecha de eliminación lógica (SoftDeletes) |

### Índices y Restricciones
- `UNIQUE (slug)`
- `INDEX idx_[tabla]_status_active (status, is_active)`
- `INDEX idx_[tabla]_published_at (published_at)`
- `FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE`

---

## 4. Relaciones, Scopes y Métodos Relevantes

### Relaciones Eloquent
- `user(): BelongsTo<User, static>`: Relación con el usuario autor o gestor.
- `categories(): BelongsToMany<Category>`: Taxonomía compartida (si aplica).

### Scopes Locales
- `scopePublished(Builder $query): Builder`: Filtra registros con `status = ContentStatus::Published`.
- `scopeActive(Builder $query): Builder`: Filtra registros con `is_active = true`.
- `scopePublishedAndActive(Builder $query): Builder`: Combinación para consultas públicas del frontend.
- `scopeOrdered(Builder $query): Builder`: Ordena por `order ASC` o `published_at DESC`.

### Accessors y Métodos Auxiliares
- `getImageUrlAttribute(): ?string`: Resuelve dinámicamente `Storage::disk('public')->url($this->image)` o `storage_image($this->image)`.
- `getSeoTitleText(): string`: Fallback dinámico para etiquetas meta SEO según el idioma activo.

---

## 5. Rutas Web y API

### Rutas Web Públicas (`routes/web.php`)
| Método | URI | Nombre de Ruta | Middleware | Descripción |
|--------|-----|----------------|------------|-------------|
| `GET` | `/[modulo]` | `[modulo].index` | `web` | Listado paginado con filtros |
| `GET` | `/[modulo]/{slug}` | `[modulo].show` | `web` | Vista detallada del registro |
| `POST` | `/[modulo]/contacto` | `[modulo].send` | `web`, `throttle:10,1` | Envíos públicos protegidos |

### Rutas API REST (`routes/api.php`)
| Método | URI | Nombre de Ruta | Middleware | Descripción |
|--------|-----|----------------|------------|-------------|
| `GET` | `/api/v1/[modulo]` | `api.v1.[modulo].index` | `api` | Listado paginado en formato JSON |
| `GET` | `/api/v1/[modulo]/{slug}` | `api.v1.[modulo].show` | `api` | Detalle del elemento en formato JSON |
| `POST` | `/api/v1/[modulo]` | `api.v1.[modulo].store` | `auth:sanctum` | Creación protegida con Bearer token |

---

## 6. Configuración en Filament (`/admin`)

- **Resource**: `App\Filament\Admin\Resources\[Modelo]Resource`
- **Grupo de Navegación**: `__('filament.nav_content')`
- **Icono de Navegación**: `heroicon-o-document-text` (Heroicons v2)
- **Orden de Menú**: `navigationSort = 3`
- **Permisos y Políticas**:
  - `superadmin`: Control total (crear, editar, eliminar registros de cualquier usuario).
  - `admin`: Gestión de contenido propio y publicación.
  - `user`: Sin acceso al panel de administración.

### Campos Principales del Formulario
- `Tabs` o `Section`: Pestañas para "Contenido" y "SEO y Metadatos".
- `TextInput::make('title')`: Traducible o estándar con auto-generación de slug en modo creación.
- `FileUpload`: Mediante `ImageCropField::make16x9('image', '[modulo]')` con `->imageEditor()`.
- `RichEditor` / `Builder`: Contenido estructurado o editor de bloques modulares.
- `Select::make('status')`: Opciones respaldadas por Enum (`ContentStatus::cases()`).

---

## 7. Contenido Gestionable

| Sección del Panel | Campos Editables | Soporte Multiidioma | Comportamiento en Frontend |
|-------------------|------------------|:-------------------:|----------------------------|
| **Datos Generales** | Título, Extracto, Contenido | Sí (`es`, `en`) | Muestra el texto según el locale de sesión |
| **Multimedia** | Imagen principal, Imagen vertical | No | Se renderiza optimizada con ratio específico |
| **Publicación** | Estado (`draft`/`published`), Activo, Fecha | No | Los borradores devuelven HTTP 404 en la web pública |
| **SEO** | Meta title, Meta description, Keywords | Sí (`es`, `en`) | Inyectadas dinámicamente en el `<head>` HTML |
