<?php
return [
    // Grupos de navegación
    'nav_content'  => 'Contenido',
    'nav_media'    => 'Media',
    'nav_frontend' => 'Frontend',
    'nav_system'   => 'Sistema',
    'nav_actions'  => 'Acciones',

    // Recursos — Labels de módulo
    'user'         => 'Usuario',
    'users'        => 'Usuarios',
    'page'         => 'Página',
    'pages'        => 'Páginas',
    'post'         => 'Post',
    'posts'        => 'Posts',
    'category'     => 'Categoría',
    'categories'   => 'Categorías',
    'slide'        => 'Slide',
    'slides'       => 'Slides',
    'section'      => 'Sección',
    'sections'     => 'Secciones',
    'setting'      => 'Configuración',
    'settings'     => 'Configuraciones',
    'sent_email'   => 'Email enviado',
    'sent_emails'  => 'Emails enviados',

    // Campos comunes
    'name'           => 'Nombre',
    'email'          => 'Email',
    'password'       => 'Contraseña',
    'role'           => 'Rol',
    'avatar'         => 'Avatar',
    'is_active'      => 'Activo',
    'slug'           => 'Slug',
    'title'          => 'Título',
    'content'        => 'Contenido',
    'description'    => 'Descripción',
    'excerpt'        => 'Extracto',
    'image'          => 'Imagen',
    'image_vertical' => 'Imagen vertical',
    'status'         => 'Estado',
    'featured'       => 'Destacado',
    'published_at'   => 'Fecha de publicación',
    'created_at'     => 'Fecha de creación',
    'updated_at'     => 'Fecha de actualización',
    'zone'           => 'Zona',
    'order'          => 'Orden',
    'url'            => 'URL',
    'key'            => 'Clave',
    'value'          => 'Valor',
    'display_name'   => 'Nombre visible',
    'type'           => 'Tipo',
    'group'          => 'Grupo',
    'details'        => 'Detalles',

    // Campos SEO
    'seo_title'       => 'Título SEO',
    'seo_description' => 'Descripción SEO',
    'seo_keywords'    => 'Palabras clave SEO',

    // Campos de emails
    'to'              => 'Destinatario',
    'from'            => 'Remitente',
    'subject'         => 'Asunto',
    'mailable_class'  => 'Clase Mailable',
    'body'            => 'Cuerpo',
    'metadata'        => 'Metadatos',
    'error_message'   => 'Mensaje de error',

    // Tabs de traducciones
    'tab_spanish'  => 'Español',
    'tab_english'  => 'English',

    // Pestañas de formulario
    'translations' => 'Traducciones',

    // Acciones
    'create_new'  => 'Crear nuevo',
    'save'        => 'Guardar',
    'cancel'      => 'Cancelar',
    'delete'      => 'Eliminar',
    'edit'        => 'Editar',
    'view'        => 'Ver',
    'close'       => 'Cerrar',
    'confirm'     => 'Confirmar',

    // Tipos de configuración
    'type_text'     => 'Texto',
    'type_textarea' => 'Área de texto',
    'type_image'    => 'Imagen',
    'type_number'   => 'Número',

    // Panel de usuario
    'my_profile'    => 'Mi Perfil',
    'api_tokens'    => 'Tokens de API',
    'api_tokens_nav'=> 'Tokens API',

    // Acciones admin
    'regenerate_sitemap' => 'Regenerar Sitemap',
    'clear_cache'        => 'Limpiar Caché',
    'view_logs'          => 'Ver Logs',

    // Acciones — Modals y notificaciones
    'regenerate_sitemap_confirm'       => '¿Estás seguro de que deseas regenerar el sitemap.xml? Este proceso puede tardar unos segundos.',
    'regenerate_sitemap_success'       => 'Sitemap regenerado correctamente.',
    'regenerate_sitemap_success_body'  => 'El archivo sitemap.xml ha sido actualizado.',
    'regenerate_sitemap_desc'          => 'El sitemap.xml es un archivo que indica a los motores de búsqueda (Google, Bing, etc.) las páginas disponibles en el sitio web. Al regenerarlo, se actualizan todas las URLs con los últimos posts, páginas y contenido publicado.',
    'regenerate_sitemap_location'      => 'Ubicación del archivo:',
    'clear_cache_confirm'              => "¿Estás seguro de que deseas limpiar toda la caché?\n\nSe cerrarán las sesiones, se vaciará la caché y las colas de eventos pueden interrumpirse.",
    'clear_cache_success'              => 'Caché limpiada correctamente.',
    'clear_cache_success_body'         => 'Toda la caché del sistema ha sido eliminada.',
    'clear_cache_desc'                 => 'Esta acción limpia toda la caché del sistema. Úsala cuando hayas realizado cambios de configuración o cuando las páginas no muestren los datos actualizados.',
    'clear_cache_warning'              => 'Advertencia',
    'clear_cache_warn_sessions'        => 'Se cerrarán todas las sesiones activas de usuarios',
    'clear_cache_warn_data'            => 'Se vaciarán datos en caché (settings, consultas, etc.)',
    'clear_cache_warn_queues'          => 'Las colas de eventos pendientes pueden interrumpirse',
    'clear_cache_warn_slow'            => 'La primera carga será más lenta hasta regenerar caché',
    'view_logs_desc'                   => 'Listado de los archivos de log de Laravel. Puedes ver su contenido o descargarlos para depuración.',
    'view_logs_col_file'               => 'Archivo',
    'view_logs_col_size'               => 'Tamaño',
    'view_logs_col_modified'           => 'Última modificación',
    'view_logs_col_actions'            => 'Acciones',
    'view_logs_empty'                  => 'No hay archivos de log disponibles.',
    'view_logs_view'                   => 'Ver',
    'view_logs_download'               => 'Descargar',
    'view_logs_not_found'              => 'Archivo no encontrado.',

    // Dashboard widgets
    'active_users'      => 'Usuarios activos',
    'active_users_desc' => 'Total de usuarios con cuenta activa',
    'published_posts'   => 'Posts publicados',
    'published_posts_desc' => 'Artículos en estado publicado',
    'published_pages'   => 'Páginas publicadas',
    'published_pages_desc' => 'Páginas en estado publicado',
    'sent_emails_count' => 'Emails enviados',
    'sent_emails_desc'  => 'Total de emails registrados',
    'latest_emails'     => 'Últimos emails enviados',
    'posts_by_month'    => 'Posts creados por mes',
    'download_error_log'=> 'Logs',

    // Textos de expiración
    'expires_at'   => 'Fecha de expiración',
    'last_used_at' => 'Último uso',
    'token_name'   => 'Nombre del token',
];
