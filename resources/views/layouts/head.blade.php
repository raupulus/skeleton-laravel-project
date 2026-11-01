@php
    $seoData = isset($seo) && method_exists($seo, 'toArray') ? $seo->toArray() : [];
    $pageTitle = $seoData['title'] ?? setting('site_title', config('app.name'));
    $pageDescription = $seoData['description'] ?? setting('site_description', '');
    $pageKeywords = $seoData['keywords'] ?? setting('default_meta_keywords', '');
    $pageImage = $seoData['image'] ?? asset('images/redes-sociales/social-network-1200x1200.webp');
    $pageUrl = $seoData['url'] ?? url()->current();
    $pageType = $seoData['type'] ?? 'website';
    $pageRobots = $seoData['robots'] ?? 'index,follow';
    $currentLocale = app()->getLocale();
    $availableLocales = config('locales.available', ['es', 'en']);
@endphp
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta http-equiv="Content-Language" content="{{ $currentLocale }}" />
<meta name="distribution" content="global" />
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}" />
<meta name="keywords" content="{{ $pageKeywords }}" />
<meta name="author" content="{{ $seoData['author'] ?? setting('site_title', config('app.name')) }}" />
<meta name="robots" content="{{ $pageRobots }}" />
<link rel="canonical" href="{{ $pageUrl }}" />
@foreach($availableLocales as $loc)
<link rel="alternate" hreflang="{{ $loc }}" href="{{ $pageUrl }}?lang={{ $loc }}" />
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ $pageUrl }}" />
<meta property="og:locale" content="{{ $currentLocale === 'es' ? 'es_ES' : 'en_US' }}" />
<meta property="og:title" content="{{ $pageTitle }}" />
<meta property="og:site_name" content="{{ setting('site_title', config('app.name')) }}" />
<meta property="og:type" content="{{ $pageType }}" />
<meta property="og:description" content="{{ $pageDescription }}" />
<meta property="og:image" content="{{ $pageImage }}" />
<meta property="og:image:alt" content="{{ $pageDescription }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="1200" />
<meta property="og:url" content="{{ $pageUrl }}" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $pageTitle }}" />
<meta name="twitter:description" content="{{ $pageDescription }}" />
<meta name="twitter:image" content="{{ $pageImage }}" />
@if($pageType === 'article' && isset($seoData['publishedAt']))
<meta property="article:published_time" content="{{ $seoData['publishedAt'] }}" />
@endif
<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context' => 'https://schema.org',
    '@type' => $pageType === 'article' ? 'Article' : 'WebSite',
    'name' => $pageTitle,
    'description' => $pageDescription,
    'url' => $pageUrl,
    'image' => $pageImage,
    'author' => ($pageType === 'article' && isset($seoData['author'])) ? ['@type' => 'Person', 'name' => $seoData['author']] : null,
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logos/logo-180x180.png') }}" />
<link rel="icon" type="image/png" sizes="64x64" href="{{ asset('images/logos/logo-64x64.png') }}" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logos/logo-32x32.png') }}" />
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logos/logo-16x16.png') }}" />
