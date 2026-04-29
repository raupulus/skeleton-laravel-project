# Fase 14 — Optimización y pulido

## Resumen
En esta fase se revisará el rendimiento del proyecto: eager loading, caché de queries, índices de BD y configuraciones de producción.

**Dependencias**: Fases 01-13 completadas.

---

## Paso 14.1 — Eager loading

Revisar todos los controladores y asegurar que las relaciones se cargan con `with()` para evitar N+1:

- `PostController::index()` → `with('categories', 'user')`
- `PostController::show()` → `with('categories', 'user')`
- `PageController::show()` → `with('categories')`
- `HomeController::index()` → posts con `with('categories')`
- Recursos Filament: configurar `$table->query()` con `with()` en las relaciones mostradas en tabla

Instalar y usar `barryvdh/laravel-debugbar` en desarrollo para detectar N+1:

```bash
composer require barryvdh/laravel-debugbar --dev
```

---

## Paso 14.2 — Caché de queries frecuentes

### Settings
Ya implementado en `SettingService` (Fase 06) con caché de 1 hora.

### Sections
Añadir caché en las queries de secciones usadas en layouts/vistas:

```php
// En el controlador o en un ViewComposer:
$sections = Cache::remember("sections_{$zone}", 3600, function () use ($zone) {
    return Section::forZone($zone)->get();
});
```

### Slides
Similar para slides frecuentes:

```php
$slides = Cache::remember("slides_{$zone}", 3600, function () use ($zone) {
    return Slide::forZone($zone)->get();
});
```

### Invalidar caché
Añadir observers o hooks en los Resources de Filament para limpiar caché al crear/editar/eliminar secciones y slides:

```php
// En SectionResource después de guardar:
Cache::forget("sections_{$record->zone}");

// En SlideResource después de guardar:
Cache::forget("slides_{$record->zone}");
```

---

## Paso 14.3 — Revisión de índices

Verificar que los índices creados en las migraciones (Fase 02) cubren las queries generadas:

- `posts`: status + is_active + published_at (índice compuesto para `publishedAndActive()->orderByDesc('published_at')`)
- `pages`: status + is_active (para `publishedAndActive()`)
- `slides`: zone + is_active + order (ya tiene índice compuesto)
- `sections`: zone + order (ya tiene índice compuesto)
- `settings`: key (ya es unique), group + order
- `sent_emails`: status, created_at

Si faltan índices compuestos, crear una nueva migración:

```bash
php artisan make:migration add_composite_indexes
```

```php
Schema::table('posts', function (Blueprint $table) {
    $table->index(['status', 'is_active', 'published_at'], 'idx_posts_status_active_published');
});

Schema::table('pages', function (Blueprint $table) {
    $table->index(['status', 'is_active'], 'idx_pages_status_active');
});
```

---

## Paso 14.4 — Configuraciones de producción

Documentar en `docs/deploys/` los comandos de optimización para producción:

```bash
# Caché de configuración
php artisan config:cache

# Caché de rutas
php artisan route:cache

# Caché de vistas
php artisan view:cache

# Caché de eventos
php artisan event:cache

# Optimización general
php artisan optimize
```

---

## Checklist de verificación

- [ ] Eager loading aplicado en todos los controladores con relaciones
- [ ] No hay queries N+1 (verificado con debugbar)
- [ ] Caché implementada para settings, sections y slides
- [ ] Caché invalidada al modificar desde Filament
- [ ] Índices compuestos añadidos para queries frecuentes
- [ ] Comandos de optimización para producción documentados
