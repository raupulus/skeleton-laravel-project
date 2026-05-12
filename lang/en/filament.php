<?php
return [
    // Navigation groups
    'nav_content'  => 'Content',
    'nav_media'    => 'Media',
    'nav_frontend' => 'Frontend',
    'nav_system'   => 'System',
    'nav_actions'  => 'Actions',

    // Resources — Module labels
    'user'         => 'User',
    'users'        => 'Users',
    'page'         => 'Page',
    'pages'        => 'Pages',
    'post'         => 'Post',
    'posts'        => 'Posts',
    'category'     => 'Category',
    'categories'   => 'Categories',
    'slide'        => 'Slide',
    'slides'       => 'Slides',
    'section'      => 'Section',
    'sections'     => 'Sections',
    'setting'      => 'Setting',
    'settings'     => 'Settings',
    'sent_email'   => 'Sent email',
    'sent_emails'  => 'Sent emails',

    // Common fields
    'name'           => 'Name',
    'email'          => 'Email',
    'password'       => 'Password',
    'role'           => 'Role',
    'avatar'         => 'Avatar',
    'is_active'      => 'Active',
    'slug'           => 'Slug',
    'title'          => 'Title',
    'content'        => 'Content',
    'description'    => 'Description',
    'excerpt'        => 'Excerpt',
    'image'          => 'Image',
    'image_vertical' => 'Vertical image',
    'status'         => 'Status',
    'featured'       => 'Featured',
    'published_at'   => 'Published at',
    'created_at'     => 'Created at',
    'updated_at'     => 'Updated at',
    'zone'           => 'Zone',
    'order'          => 'Order',
    'url'            => 'URL',
    'key'            => 'Key',
    'value'          => 'Value',
    'display_name'   => 'Display name',
    'type'           => 'Type',
    'group'          => 'Group',
    'details'        => 'Details',

    // SEO fields
    'seo_title'       => 'SEO Title',
    'seo_description' => 'SEO Description',
    'seo_keywords'    => 'SEO Keywords',

    // Email fields
    'to'              => 'To',
    'from'            => 'From',
    'subject'         => 'Subject',
    'mailable_class'  => 'Mailable class',
    'body'            => 'Body',
    'metadata'        => 'Metadata',
    'error_message'   => 'Error message',

    // Translation tabs
    'tab_spanish'  => 'Español',
    'tab_english'  => 'English',

    // Form tabs
    'translations' => 'Translations',

    // Actions
    'create_new'  => 'Create new',
    'save'        => 'Save',
    'cancel'      => 'Cancel',
    'delete'      => 'Delete',
    'edit'        => 'Edit',
    'view'        => 'View',
    'close'       => 'Close',
    'confirm'     => 'Confirm',

    // Setting types
    'type_text'     => 'Text',
    'type_textarea' => 'Textarea',
    'type_image'    => 'Image',
    'type_number'   => 'Number',

    // User panel
    'my_profile'    => 'My Profile',
    'api_tokens'    => 'API Tokens',
    'api_tokens_nav'=> 'API Tokens',

    // Admin actions
    'regenerate_sitemap' => 'Regenerate Sitemap',
    'clear_cache'        => 'Clear Cache',
    'view_logs'          => 'View Logs',

    // Actions — Modals and notifications
    'regenerate_sitemap_confirm'       => 'Are you sure you want to regenerate sitemap.xml? This process may take a few seconds.',
    'regenerate_sitemap_success'       => 'Sitemap regenerated successfully.',
    'regenerate_sitemap_success_body'  => 'The sitemap.xml file has been updated.',
    'regenerate_sitemap_desc'          => 'The sitemap.xml file tells search engines which pages are available. Regenerating it updates all URLs with the latest content.',
    'regenerate_sitemap_location'      => 'File location:',
    'clear_cache_confirm'              => "Are you sure you want to clear all cache?\n\nSessions will be closed, cache will be emptied and event queues may be interrupted.",
    'clear_cache_success'              => 'Cache cleared successfully.',
    'clear_cache_success_body'         => 'All system cache has been removed.',
    'clear_cache_desc'                 => 'This action clears all system cache. Use it when you have made configuration changes or pages are not showing updated data.',
    'clear_cache_warning'              => 'Warning',
    'clear_cache_warn_sessions'        => 'All active user sessions will be closed',
    'clear_cache_warn_data'            => 'Cached data will be emptied (settings, queries, etc.)',
    'clear_cache_warn_queues'          => 'Pending event queues may be interrupted',
    'clear_cache_warn_slow'            => 'First page load will be slower until cache is rebuilt',
    'view_logs_desc'                   => 'List of Laravel log files. You can view their content or download them for debugging.',
    'view_logs_col_file'               => 'File',
    'view_logs_col_size'               => 'Size',
    'view_logs_col_modified'           => 'Last modified',
    'view_logs_col_actions'            => 'Actions',
    'view_logs_empty'                  => 'No log files available.',
    'view_logs_view'                   => 'View',
    'view_logs_download'               => 'Download',
    'view_logs_not_found'              => 'File not found.',

    // Dashboard widgets
    'active_users'      => 'Active users',
    'active_users_desc' => 'Total users with active account',
    'published_posts'   => 'Published posts',
    'published_posts_desc' => 'Articles in published status',
    'published_pages'   => 'Published pages',
    'published_pages_desc' => 'Pages in published status',
    'sent_emails_count' => 'Sent emails',
    'sent_emails_desc'  => 'Total registered emails',
    'latest_emails'     => 'Latest sent emails',
    'posts_by_month'    => 'Posts created per month',
    'download_error_log'=> 'Download error log',

    // Expiration texts
    'expires_at'   => 'Expires at',
    'last_used_at' => 'Last used at',
    'token_name'   => 'Token name',
];
