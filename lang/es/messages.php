<?php

return [
    // Navegación
    'welcome' => 'Bienvenido',
    'home' => 'Inicio',
    'about' => 'Sobre nosotros',
    'contact' => 'Contacto',
    'blog' => 'Blog',
    'pages' => 'Páginas',
    'privacy' => 'Política de privacidad',
    'cookies' => 'Política de cookies',

    // Autenticación
    'login' => 'Iniciar sesión',
    'register' => 'Registrarse',
    'logout' => 'Cerrar sesión',
    'profile' => 'Perfil',

    // Acciones
    'settings' => 'Configuración',
    'search' => 'Buscar',
    'read_more' => 'Leer más',
    'back' => 'Volver',
    'save' => 'Guardar',
    'cancel' => 'Cancelar',
    'delete' => 'Eliminar',
    'edit' => 'Editar',
    'create' => 'Crear',
    'update' => 'Actualizar',

    // Estados
    'published' => 'Publicado',
    'draft' => 'Borrador',
    'featured' => 'Destacado',
    'active' => 'Activo',
    'inactive' => 'Inactivo',

    // General
    'all_rights_reserved' => 'Todos los derechos reservados',
    'language' => 'Idioma',
    'no_results' => 'No se encontraron resultados',

    // Contacto
    'contact_success' => 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.',
    'contact_error' => 'Hubo un error al enviar el mensaje. Inténtalo de nuevo.',

    // ============================================================
    // Home — Hero
    // ============================================================
    'home_hero_badge' => 'Laravel 13 · Filament 5 · Tailwind 4 · Vue 3',
    'home_hero_title' => 'Skeleton Laravel Project',
    'home_hero_description' => 'Plantilla base lista para producción. Incluye autenticación completa, panel admin Filament, API REST con Sanctum, traducciones, SEO, Docker y todo lo necesario para arrancar tu próximo proyecto en minutos.',
    'home_hero_btn_docs' => 'Documentación en el Blog',
    'home_hero_btn_admin' => 'Panel Admin',
    'home_hero_btn_api' => 'API Docs',

    // Home — Quick Start
    'home_quickstart_title' => 'Inicio rápido',

    // Home — Features
    'home_features_title' => 'Todo lo que necesitas, ya implementado',
    'home_features_description' => 'No empieces desde cero. Este skeleton cubre las funcionalidades más comunes de cualquier proyecto Laravel profesional.',

    'home_feat_auth_title' => 'Autenticación completa',
    'home_feat_auth_desc' => 'Login, registro, verificación de email y recuperación de contraseña — tanto para web como para API REST con Sanctum.',

    'home_feat_filament_title' => 'Panel Admin Filament 5',
    'home_feat_filament_desc' => 'Dos paneles separados: /admin para administradores y /panel para usuarios. CRUD completo de todos los modelos.',

    'home_feat_api_title' => 'API REST documentada',
    'home_feat_api_desc' => 'API versionada en /api/v1 con autenticación Sanctum. Documentación auto-generada con Scribe en /docs.',

    'home_feat_i18n_title' => 'Bilingüe ES / EN',
    'home_feat_i18n_desc' => 'Español e inglés en toda la interfaz. Modelos con campos traducibles vía spatie/laravel-translatable. Selector de idioma en el frontend.',

    'home_feat_seo_title' => 'SEO completo',
    'home_feat_seo_desc' => 'Meta tags, Open Graph, Twitter Cards, JSON-LD, hreflang, canonical y sitemap XML generado automáticamente con spatie/laravel-sitemap.',

    'home_feat_content_title' => 'Posts, Pages y Categorías',
    'home_feat_content_desc' => 'Sistema de contenido completo con estados (draft/published), campos SEO, imágenes, categorías y campos traducibles. Todo gestionable desde Filament.',

    'home_feat_settings_title' => 'Settings dinámicos',
    'home_feat_settings_desc' => 'Configuración del sitio gestionable desde el panel: título, descripción, redes sociales, contacto y SEO. Accesibles en cualquier parte con setting(\'key\').',

    'home_feat_docker_title' => 'Docker incluido',
    'home_feat_docker_desc' => 'Dockerización completa lista para usar: PHP 8.4, Nginx, PostgreSQL. Entorno de desarrollo y producción configurados en docker-compose.yml.',

    'home_feat_tests_title' => 'Tests incluidos',
    'home_feat_tests_desc' => 'Feature tests para autenticación web y API, acceso a paneles, formulario de contacto y tests unitarios de servicios clave con PHPUnit.',

    // Home — Stack
    'home_stack_title' => 'Stack tecnológico',

    // Home — Paneles
    'home_panels_title' => 'Paneles incluidos',
    'home_panels_description' => 'Accede a los paneles con las credenciales de los seeders en desarrollo',
    'home_panel_admin_title' => 'Panel Admin',
    'home_panel_admin_desc' => 'Gestión completa del sistema',
    'home_panel_user_title' => 'Panel Usuario',
    'home_panel_user_desc' => 'Perfil y tokens API propios',
    'home_panel_api_title' => 'API Docs',
    'home_panel_api_desc' => 'Documentación auto-generada',

    // Home — Blog
    'home_blog_subtitle' => 'Blog & Documentación',

    // Carrusel (slide-carousel)
    'slide_prev' => 'Diapositiva anterior',
    'slide_next' => 'Diapositiva siguiente',
    'slide_go_to' => 'Ir a la diapositiva :n',

    // Paginación
    'pagination' => 'Paginación',

    // Panel de usuario — Widget de bienvenida
    'welcome_greeting' => '¡Hola, :name!',
    'active_tokens_count' => 'Tienes :count token(s) API activos.',

    // Páginas legales — Textos por defecto
    'privacy_default_text' => 'El contenido de la política de privacidad se gestiona desde el panel de administración (Secciones → zona "privacy").',
    'cookies_default_text' => 'El contenido de la política de cookies se gestiona desde el panel de administración (Secciones → zona "cookies").',

    // Contacto — Formulario
    'contact_name' => 'Nombre',
    'contact_email' => 'Correo electrónico',
    'contact_subject' => 'Asunto',
    'contact_message' => 'Mensaje',
    'contact_privacy_accept' => 'Acepto la',
    'contact_privacy_link' => 'política de privacidad',
    'contact_send' => 'Enviar mensaje',

    // Validaciones — Contacto
    'validation_name_required' => 'El nombre es obligatorio.',
    'validation_name_max' => 'El nombre no puede superar 255 caracteres.',
    'validation_email_required' => 'El correo electrónico es obligatorio.',
    'validation_email_email' => 'El correo electrónico no es válido.',
    'validation_subject_required' => 'El asunto es obligatorio.',
    'validation_message_required' => 'El mensaje es obligatorio.',
    'validation_message_max' => 'El mensaje no puede superar 5.000 caracteres.',
    'validation_privacy_required' => 'Debes aceptar la política de privacidad.',
    'validation_privacy_accepted' => 'Debes aceptar la política de privacidad.',

    // Panel usuario — Tokens API
    'api_tokens_description' => 'Los tokens de API te permiten conectar aplicaciones externas con tu cuenta de forma segura. Cada token actúa como una "contraseña temporal" que puedes revocar en cualquier momento sin afectar a tu contraseña principal.',
    'api_tokens_create_title' => 'Crear nuevo token',
    'api_tokens_placeholder' => 'Nombre del token (ej: Mi aplicación)',
    'api_tokens_created_msg' => 'Token generado — cópialo ahora, no se mostrará de nuevo:',
    'api_tokens_copy' => 'Copiar',
    'api_tokens_copied' => '¡Copiado!',
    'api_tokens_list_title' => 'Tokens activos',
    'api_tokens_col_name' => 'Nombre',
    'api_tokens_col_created' => 'Creado',
    'api_tokens_col_last_used' => 'Último uso',
    'api_tokens_col_expires' => 'Expira',
    'api_tokens_col_actions' => 'Acciones',
    'api_tokens_empty' => 'No tienes tokens de API creados.',
    'api_tokens_delete_confirm' => '¿Seguro que quieres eliminar este token?',
    'api_tokens_never' => 'Nunca',
    'api_tokens_no_expiry' => 'Sin expiración',
    'api_tokens_created_notify' => 'Token creado correctamente.',
    'api_tokens_deleted_notify' => 'Token eliminado correctamente.',
    'validation_token_name_required' => 'El nombre del token es obligatorio.',
    'validation_token_name_max' => 'El nombre no puede superar los 255 caracteres.',

    // Panel usuario — Perfil
    'profile_email_helper' => 'Si necesitas modificar tu email, contacta con el administrador.',
    'profile_password_helper' => 'Déjalo en blanco si no deseas cambiar la contraseña.',
    'profile_updated' => 'Perfil actualizado correctamente.',
];
