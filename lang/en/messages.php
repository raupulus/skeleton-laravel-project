<?php
return [
    // Navigation
    'welcome'    => 'Welcome',
    'home'       => 'Home',
    'about'      => 'About us',
    'contact'    => 'Contact',
    'blog'       => 'Blog',
    'pages'      => 'Pages',
    'privacy'    => 'Privacy policy',
    'cookies'    => 'Cookies policy',

    // Authentication
    'login'    => 'Login',
    'register' => 'Register',
    'logout'   => 'Logout',
    'profile'  => 'Profile',

    // Actions
    'settings'  => 'Settings',
    'search'    => 'Search',
    'read_more' => 'Read more',
    'back'      => 'Back',
    'save'      => 'Save',
    'cancel'    => 'Cancel',
    'delete'    => 'Delete',
    'edit'      => 'Edit',
    'create'    => 'Create',
    'update'    => 'Update',

    // Status
    'published' => 'Published',
    'draft'     => 'Draft',
    'featured'  => 'Featured',
    'active'    => 'Active',
    'inactive'  => 'Inactive',

    // General
    'all_rights_reserved' => 'All rights reserved',
    'language'            => 'Language',
    'no_results'          => 'No results found',

    // Contact
    'contact_success' => 'Message sent successfully. We will get back to you soon.',
    'contact_error'   => 'There was an error sending the message. Please try again.',

    // ============================================================
    // Home — Hero
    // ============================================================
    'home_hero_badge'       => 'Laravel 13 · Filament 5 · Tailwind 4 · Vue 3',
    'home_hero_title'       => 'Skeleton Laravel Project',
    'home_hero_description' => 'Production-ready base template. Includes full authentication, Filament admin panel, REST API with Sanctum, translations, SEO, Docker and everything you need to start your next project in minutes.',
    'home_hero_btn_docs'    => 'Documentation on Blog',
    'home_hero_btn_admin'   => 'Admin Panel',
    'home_hero_btn_api'     => 'API Docs',

    // Home — Quick Start
    'home_quickstart_title' => 'Quick start',

    // Home — Features
    'home_features_title'       => 'Everything you need, already implemented',
    'home_features_description' => 'Don\'t start from scratch. This skeleton covers the most common features of any professional Laravel project.',

    'home_feat_auth_title' => 'Full authentication',
    'home_feat_auth_desc'  => 'Login, registration, email verification and password recovery — for both web and REST API with Sanctum.',

    'home_feat_filament_title' => 'Filament 5 Admin Panel',
    'home_feat_filament_desc'  => 'Two separate panels: /admin for administrators and /panel for users. Full CRUD for all models.',

    'home_feat_api_title' => 'Documented REST API',
    'home_feat_api_desc'  => 'Versioned API at /api/v1 with Sanctum authentication. Auto-generated documentation with Scribe at /docs.',

    'home_feat_i18n_title' => 'Bilingual ES / EN',
    'home_feat_i18n_desc'  => 'Spanish and English across the entire interface. Models with translatable fields via spatie/laravel-translatable. Language selector on the frontend.',

    'home_feat_seo_title' => 'Complete SEO',
    'home_feat_seo_desc'  => 'Meta tags, Open Graph, Twitter Cards, JSON-LD, hreflang, canonical and XML sitemap auto-generated with spatie/laravel-sitemap.',

    'home_feat_content_title' => 'Posts, Pages & Categories',
    'home_feat_content_desc'  => 'Complete content system with statuses (draft/published), SEO fields, images, categories and translatable fields. All manageable from Filament.',

    'home_feat_settings_title' => 'Dynamic settings',
    'home_feat_settings_desc'  => 'Site configuration manageable from the panel: title, description, social media, contact and SEO. Accessible anywhere with setting(\'key\').',

    'home_feat_docker_title' => 'Docker included',
    'home_feat_docker_desc'  => 'Full Docker setup ready to use: PHP 8.4, Nginx, PostgreSQL. Development and production environments configured in docker-compose.yml.',

    'home_feat_tests_title' => 'Tests included',
    'home_feat_tests_desc'  => 'Feature tests for web and API authentication, panel access, contact form and unit tests for key services with PHPUnit.',

    // Home — Stack
    'home_stack_title' => 'Technology stack',

    // Home — Panels
    'home_panels_title'       => 'Included panels',
    'home_panels_description' => 'Access the panels with seeder credentials in development',
    'home_panel_admin_title'  => 'Admin Panel',
    'home_panel_admin_desc'   => 'Full system management',
    'home_panel_user_title'   => 'User Panel',
    'home_panel_user_desc'    => 'Profile and own API tokens',
    'home_panel_api_title'    => 'API Docs',
    'home_panel_api_desc'     => 'Auto-generated documentation',

    // Home — Blog
    'home_blog_subtitle' => 'Blog & Documentation',

    // Carousel (slide-carousel)
    'slide_prev'   => 'Previous slide',
    'slide_next'   => 'Next slide',
    'slide_go_to'  => 'Go to slide :n',

    // Pagination
    'pagination' => 'Pagination',

    // User panel — Welcome widget
    'welcome_greeting'     => 'Hello, :name!',
    'active_tokens_count'  => 'You have :count active API token(s).',

    // Legal pages — Default texts
    'privacy_default_text' => 'Privacy policy content is managed from the admin panel (Sections → zone "privacy").',
    'cookies_default_text' => 'Cookies policy content is managed from the admin panel (Sections → zone "cookies").',

    // Contact — Form
    'contact_name'           => 'Name',
    'contact_email'          => 'Email',
    'contact_subject'        => 'Subject',
    'contact_message'        => 'Message',
    'contact_privacy_accept' => 'I accept the',
    'contact_privacy_link'   => 'privacy policy',
    'contact_send'           => 'Send message',

    // Validations — Contact
    'validation_name_required'    => 'Name is required.',
    'validation_name_max'         => 'Name cannot exceed 255 characters.',
    'validation_email_required'   => 'Email is required.',
    'validation_email_email'      => 'Email is not valid.',
    'validation_subject_required' => 'Subject is required.',
    'validation_message_required' => 'Message is required.',
    'validation_message_max'      => 'Message cannot exceed 5,000 characters.',
    'validation_privacy_required' => 'You must accept the privacy policy.',
    'validation_privacy_accepted' => 'You must accept the privacy policy.',

    // User panel — API Tokens
    'api_tokens_description'    => 'API tokens allow you to securely connect external applications to your account. Each token acts as a "temporary password" that you can revoke at any time without affecting your main password.',
    'api_tokens_create_title'   => 'Create new token',
    'api_tokens_placeholder'    => 'Token name (e.g. My application)',
    'api_tokens_created_msg'    => 'Token generated — copy it now, it won\'t be shown again:',
    'api_tokens_copy'           => 'Copy',
    'api_tokens_copied'         => 'Copied!',
    'api_tokens_list_title'     => 'Active tokens',
    'api_tokens_col_name'       => 'Name',
    'api_tokens_col_created'    => 'Created',
    'api_tokens_col_last_used'  => 'Last used',
    'api_tokens_col_expires'    => 'Expires',
    'api_tokens_col_actions'    => 'Actions',
    'api_tokens_empty'          => 'You don\'t have any API tokens created.',
    'api_tokens_delete_confirm' => 'Are you sure you want to delete this token?',
    'api_tokens_never'          => 'Never',
    'api_tokens_no_expiry'      => 'No expiry',
    'api_tokens_created_notify' => 'Token created successfully.',
    'api_tokens_deleted_notify' => 'Token deleted successfully.',
    'validation_token_name_required' => 'Token name is required.',
    'validation_token_name_max'      => 'Name cannot exceed 255 characters.',

    // User panel — Profile
    'profile_email_helper'    => 'If you need to change your email, please contact the administrator.',
    'profile_password_helper' => 'Leave blank if you don\'t want to change your password.',
    'profile_updated'         => 'Profile updated successfully.',
];
