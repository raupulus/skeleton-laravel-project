# Módulo: Panel Admin (Filament)

> Panel de administración completo en `/admin` con CRUD de todos los modelos, dashboard con widgets y navegación organizada por grupos.

---

## Objetivo y funcionalidad

El panel de administración es la interfaz principal de gestión de toda la plataforma. Su objetivo es proporcionar a los administradores (roles `superadmin` y `admin`) un backend completo, intuitivo y funcional donde puedan gestionar todos los aspectos del sitio web sin necesidad de acceder al código.

El panel se construye con Filament 5 y se accede en `/admin`. Incluye Resources CRUD para cada modelo del sistema: usuarios, páginas, posts, categorías, slides, secciones, configuración y emails enviados. Los Resources están organizados en grupos de navegación temáticos (Contenido, Media, Frontend, Sistema) para facilitar la orientación.

El dashboard muestra widgets con métricas en tiempo real: tarjetas de estadísticas (usuarios activos, posts publicados, páginas publicadas, emails enviados), un gráfico de barras con la evolución de posts por mes y una tabla con los últimos emails enviados. Cada Resource ofrece listados con columnas configurables, búsqueda, filtros, ordenación, acciones de edición y formularios con tabs de traducción (ES/EN) para los modelos traducibles.

El acceso al panel está restringido por el método `canAccessPanel()` del modelo User, que verifica que el usuario tenga rol de administrador y cuenta activa. Las policies de cada modelo controlan adicionalmente qué acciones puede realizar cada rol.

---

## Resumen

El panel admin está construido con Filament 5 y se accede en `/admin`. Solo pueden acceder los usuarios con `role=admin` o `role=superadmin` que tengan `is_active=true`. Incluye Resources para gestionar Users, Pages, Posts, Categories, Slides, Sections, Settings y SentEmails, junto con widgets de dashboard (estadísticas, gráfico de posts, últimos emails).

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Panel Provider | `app/Providers/Filament/AdminPanelProvider.php` |
| Resources | `app/Filament/Admin/Resources/` |
| Pages | `app/Filament/Admin/Pages/` |
| Widgets | `app/Filament/Admin/Widgets/` |

---

## Resources disponibles

| Resource | Modelo | Grupo de navegación | Icono |
|----------|--------|:-------------------:|-------|
| `UserResource` | User | Sistema | `heroicon-o-users` |
| `PageResource` | Page | Contenido | `heroicon-o-document-text` |
| `PostResource` | Post | Contenido | `heroicon-o-newspaper` |
| `CategoryResource` | Category | Contenido | `heroicon-o-tag` |
| `SlideResource` | Slide | Media | `heroicon-o-photo` |
| `SectionResource` | Section | Frontend | `heroicon-o-squares-2x2` |
| `SettingResource` | Setting | Sistema | `heroicon-o-cog-6-tooth` |
| `SentEmailResource` | SentEmail | Sistema | `heroicon-o-envelope` |

---

## Grupos de navegación

| Grupo | Resources / Pages |
|-------|-----------|
| **Contenido** | Páginas, Posts, Categorías |
| **Media** | Slides |
| **Frontend** | Secciones |
| **Sistema** | Usuarios, Configuración, Emails Enviados |
| **Acciones** | Regenerar Sitemap, Limpiar Caché, Ver Logs |

**Orden en el menú**: Contenido → Media → Frontend → Sistema → Acciones

---

## Configuración del panel

| Característica | Estado |
|---------------|--------|
| Alertas de cambios no guardados | ✅ Activado (`unsavedChangesAlerts`) |
| Búsqueda global | ✅ Posts, Páginas, Usuarios, Categorías |
| Soft Deletes (papelera) | ✅ Con filtro TrashedFilter y acciones restaurar/eliminar permanente |
| Cambio de idioma | ✅ Selector ES/EN en menú de usuario |

---

## Dashboard Widgets

| Widget | Clase | Descripción | Orden |
|--------|-------|-------------|-------|
| `AccountWidget` | Filament nativo | Widget de bienvenida con logout | -3 |
| `LogDownloadWidget` | `App\Filament\Admin\Widgets\LogDownloadWidget` | Descarga rápida del último log de errores | -2 |
| `StatsOverviewWidget` | `App\Filament\Admin\Widgets\StatsOverviewWidget` | Tarjetas con: usuarios activos, posts publicados, páginas publicadas, emails enviados | 1 |
| `PostsChartWidget` | `App\Filament\Admin\Widgets\PostsChartWidget` | Gráfico de barras con posts creados por mes (últimos 6 meses) | 2 |
| `LatestEmailsWidget` | `App\Filament\Admin\Widgets\LatestEmailsWidget` | Tabla con los 5 últimos emails enviados | 3 |

---

## Detalle de cada Resource

---

### UserResource

**Archivo**: `app/Filament/Admin/Resources/UserResource.php`

**Columnas del listado**:

| Columna | Tipo | Formato |
|---------|------|---------|
| `name` | TextColumn | Texto, buscable, ordenable |
| `email` | TextColumn | Texto, buscable, ordenable |
| `role` | TextColumn | Badge con color (primary=admin, gray=user) |
| `is_active` | IconColumn | Booleano (✓/✗) |
| `created_at` | TextColumn | Fecha `d/m/Y`, ordenable |

**Campos del formulario**:

| Campo | Tipo | Obligatorio | Notas |
|-------|------|-------------|-------|
| `name` | TextInput | Sí | Máx. 255 caracteres |
| `email` | TextInput (email) | Sí | Único (ignora el propio registro en edición) |
| `password` | TextInput (password) | Solo en creación | Min. 8 chars, no se guarda si está vacío en edición |
| `role` | Select | Sí | Opciones del enum `Role` (superadmin, admin, user) |
| `avatar` | FileUpload | No | Imagen, máx. 2MB, directorio `avatars/` |
| `is_active` | Toggle | No | Por defecto: `true` |

**Filtros**:
- `role` — SelectFilter con opciones del enum Role
- `is_active` — TernaryFilter (sí/no/todos)

**Búsqueda**: `name`, `email`

**Acciones**: EditAction (fila), DeleteBulkAction (lote)

**Particularidades**:
- `user_id` (autor) se auto-asigna mediante traits, NO aparece en el formulario
- Un usuario no puede eliminarse a sí mismo (restringido por la policy `UserPolicy`)

---

### PostResource

**Archivo**: `app/Filament/Admin/Resources/PostResource.php`

**Columnas del listado**:

| Columna | Tipo | Formato |
|---------|------|---------|
| `slug` | TextColumn | Texto, buscable, ordenable |
| `title` | TextColumn | Texto del idioma activo, buscable |
| `status` | TextColumn | Badge con color según estado (draft=gris, published=verde) |
| `featured` | IconColumn | Booleano |
| `published_at` | TextColumn | Fecha `d/m/Y`, ordenable |

**Campos del formulario** (con tabs de idioma):

| Campo | Tipo | Obligatorio | Idiomas |
|-------|------|-------------|---------|
| `title` | TextInput | Sí (ES) | ES, EN |
| `content` | RichEditor | No | ES, EN |
| `excerpt` | Textarea | No | ES, EN |
| `seo_title` | TextInput | No | ES, EN |
| `seo_description` | Textarea | No | ES, EN |
| `seo_keywords` | TextInput | No | ES, EN |
| `slug` | TextInput | No | Único (auto-generado desde título si vacío) |
| `image` | FileUpload | No | Imagen, máx. 2MB, directorio `posts/` |
| `status` | Select | No | Opciones: draft, published |
| `featured` | Toggle | No | Por defecto: false |
| `is_active` | Toggle | No | Por defecto: true |
| `categories` | Select múltiple | No | Relación con Category (many-to-many) |
| `published_at` | DateTimePicker | No | Fecha/hora de publicación |

**Búsqueda**: `slug`, `title`

**Acciones**: EditAction (fila)

**Particularidades**:
- Tabs de traducción: pestaña "Español" y pestaña "English"
- `user_id` (autor) se auto-asigna vía trait `BelongsToUser`, NO aparece en el formulario
- Los campos traducibles se almacenan como JSON en la BD

---

### PageResource

**Archivo**: `app/Filament/Admin/Resources/PageResource.php`

**Columnas del listado**:

| Columna | Tipo | Formato |
|---------|------|---------|
| `slug` | TextColumn | Texto, buscable, ordenable |
| `title` | TextColumn | Texto del idioma activo, buscable |
| `status` | TextColumn | Badge con color |
| `featured` | IconColumn | Booleano |
| `published_at` | TextColumn | Fecha `d/m/Y`, ordenable |

**Campos del formulario** (con tabs de idioma):

| Campo | Tipo | Obligatorio | Idiomas |
|-------|------|-------------|---------|
| `title` | TextInput | Sí (ES) | ES, EN |
| `content` | RichEditor | No | ES, EN |
| `excerpt` | Textarea | No | ES, EN |
| `seo_title` | TextInput | No | ES, EN |
| `seo_description` | Textarea | No | ES, EN |
| `seo_keywords` | TextInput | No | ES, EN |
| `slug` | TextInput | No | Único |
| `image` | FileUpload | No | Imagen, máx. 2MB, directorio `pages/` |
| `status` | Select | No | draft/published |
| `featured` | Toggle | No | Por defecto: false |
| `is_active` | Toggle | No | Por defecto: true |
| `categories` | Select múltiple | No | Relación many-to-many con Category |
| `published_at` | DateTimePicker | No | Fecha de publicación |

**Filtros**:
- `status` — SelectFilter con opciones del enum ContentStatus

**Búsqueda**: `slug`, `title`

**Acciones**: EditAction (fila)

**Particularidades**:
- `user_id` se auto-asigna vía trait `BelongsToUser`

---

### CategoryResource

**Archivo**: `app/Filament/Admin/Resources/CategoryResource.php`

**Columnas del listado**:

| Columna | Tipo | Formato |
|---------|------|---------|
| `slug` | TextColumn | Texto, ordenable |
| `name` | TextColumn | Texto del idioma activo, buscable |
| `is_active` | IconColumn | Booleano |
| `order` | TextColumn | Numérico, ordenable |

**Campos del formulario** (con tabs de idioma):

| Campo | Tipo | Obligatorio | Idiomas |
|-------|------|-------------|---------|
| `name` | TextInput | Sí (ES) | ES, EN |
| `description` | Textarea | No | ES, EN |
| `slug` | TextInput | No | Único |
| `image` | FileUpload | No | Imagen, máx. 2MB, directorio `categories/` |
| `is_active` | Toggle | No | Por defecto: true |
| `order` | TextInput (numérico) | No | Por defecto: 0 |

**Búsqueda**: `name`

**Acciones**: EditAction (fila)

---

### SlideResource

**Archivo**: `app/Filament/Admin/Resources/SlideResource.php`

**Columnas del listado**:

| Columna | Tipo | Formato |
|---------|------|---------|
| `image` | ImageColumn | Miniatura 40px de alto |
| `title` | TextColumn | Texto del idioma activo |
| `zone` | TextColumn | Texto, ordenable |
| `order` | TextColumn | Numérico, ordenable |
| `is_active` | IconColumn | Booleano |

**Campos del formulario** (con tabs de idioma):

| Campo | Tipo | Obligatorio | Notas |
|-------|------|-------------|-------|
| `title` | TextInput | No | ES, EN (traducible) |
| `content` | Textarea | No | ES, EN (traducible) |
| `image` | FileUpload | **Sí** | Imagen horizontal 16:9, máx. 2MB, con editor de imagen |
| `image_vertical` | FileUpload | No | Imagen vertical 8:12, máx. 2MB, con editor de imagen |
| `url` | TextInput (URL) | No | Enlace del slide |
| `zone` | TextInput | **Sí** | Nombre de zona (home, about, services, etc.) |
| `order` | TextInput (numérico) | No | Por defecto: 0 |
| `is_active` | Toggle | No | Por defecto: true |

**Ordenación por defecto**: por `zone`

**Acciones**: EditAction (fila)

---

### SectionResource

**Archivo**: `app/Filament/Admin/Resources/SectionResource.php`

**Columnas del listado**:

| Columna | Tipo | Formato |
|---------|------|---------|
| `slug` | TextColumn | Texto, ordenable |
| `zone` | TextColumn | Texto, ordenable |
| `title` | TextColumn | Texto del idioma activo |
| `order` | TextColumn | Numérico, ordenable |

**Campos del formulario** (con tabs de idioma):

| Campo | Tipo | Obligatorio | Notas |
|-------|------|-------------|-------|
| `title` | TextInput | No | ES, EN (traducible) |
| `description` | Textarea | No | ES, EN (traducible) |
| `content` | RichEditor | No | ES, EN (traducible, permite HTML) |
| `slug` | TextInput | No | Único |
| `zone` | TextInput | **Sí** | Nombre de zona (home, about, contact, privacy, cookies, etc.) |
| `image` | FileUpload | No | Imagen, máx. 2MB, directorio `sections/` |
| `order` | TextInput (numérico) | No | Por defecto: 0 |

**Ordenación por defecto**: por `zone`

**Acciones**: EditAction (fila)

---

### SettingResource

**Archivo**: `app/Filament/Admin/Resources/SettingResource.php`

**Columnas del listado**:

| Columna | Tipo | Formato |
|---------|------|---------|
| `key` | TextColumn | Texto, buscable, ordenable |
| `display_name` | TextColumn | Texto |
| `value` | TextColumn | Texto (truncado 50 chars) |
| `group` | TextColumn | Texto, ordenable |

**Campos del formulario**:

| Campo | Tipo | Obligatorio | Notas |
|-------|------|-------------|-------|
| `key` | TextInput | **Sí** | Único (la clave del setting) |
| `display_name` | TextInput | **Sí** | Nombre descriptivo para mostrar en el panel |
| `value` | Textarea | No | Valor actual del setting |
| `details` | Textarea | No | Descripción o ayuda sobre el uso del setting |
| `type` | Select | No | text, textarea, image, number |
| `order` | TextInput (numérico) | No | Por defecto: 0 |
| `group` | TextInput | No | Agrupación (general, contact, social, seo) |

**Ordenación por defecto**: por `group`

**Acciones**: EditAction (fila)

**Particularidades**:
- El valor se accede en código vía `setting('key', 'default')` o `app(SettingService::class)->get('key')`
- Los settings se cachean automáticamente 1 hora

---

### SentEmailResource

**Archivo**: `app/Filament/Admin/Resources/SentEmailResource.php`

**Columnas del listado**:

| Columna | Tipo | Formato |
|---------|------|---------|
| `to` | TextColumn | Texto, buscable |
| `subject` | TextColumn | Texto, buscable (truncado 50 chars) |
| `mailable_class` | TextColumn | Clase del Mailable (truncado 30 chars) |
| `status` | TextColumn | Badge con color (sent=verde, failed=rojo) |
| `created_at` | TextColumn | Fecha `d/m/Y H:i`, ordenable |

**Formulario**: No tiene formulario de creación (`canCreate()` devuelve `false`)

**Búsqueda**: `to`, `subject`

**Ordenación por defecto**: `created_at desc` (más reciente primero)

**Acciones**: ViewAction (fila, solo lectura)

**Particularidades**:
- Es un registro de auditoría: no se permite crear ni editar emails desde el panel
- Los registros se crean automáticamente por `EmailService::send()`

---

## Acceso

Controlado por `User::canAccessPanel(Panel $panel)`:

```php
if ($panel->getId() === 'admin') {
    return $this->role->isAdmin() && $this->is_active;
}
```

Solo `superadmin` y `admin` con cuenta activa pueden acceder.
