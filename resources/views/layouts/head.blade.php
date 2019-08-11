<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="csrf_token" content="{{ csrf_token() }}" />

@yield('meta')

<title>@yield('title', config('app.name'))</title>
<meta name="description" content="@yield('description', config('app.description'))">
<meta name="author" content="@yield('author', 'Raúl Caro Pastorino')">
<meta name="keywords" content="@yield('keywords', 'Api Fryntiz, fryntiz, chipiona, desarrollador web')" />

{{-- Redes sociales --}}
<meta property="og:title"
      content="@yield('rs-title', config('app.name'))">
<meta property="og:site_name"
      content="@yield('rs-sitename', config('app.name'))">
<meta property="og:type" content="website">
<meta property="og:description"
      content="@yield('rs-description', config('app.description'))">
<meta property="og:image"
      content="@yield('rs-image', asset('images/redes-sociales/rs-1200x1200.png')))">
<meta property="og:url"
      content="@yield('rs-url', config('app.name'))">
<meta property="og:image:alt"
      content="@yield('rs-image-alt', config('app.description'))">

<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@yield('twitter-site', '@fryntiz')">
<meta name="twitter:creator" content="@yield('twitter-creator', '@fryntiz')">

{{-- Iconos --}}
<link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/logos/180x180.png')}}">
<link rel="icon" type="image/png" sizes="64x64" href="{{asset('images/logos/64x64.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/logos/32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logos/16x16.png')}}">
