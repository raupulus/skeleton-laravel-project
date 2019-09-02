@php

@endphp

<script>
    // Dinamizar desde package.json o package-lock.json
    const bootstrap_version = '4.3.1';

    /**
     * Parámetros de la aplicación.
     */
    const app =  {
        url: "{{config('app.url')}}",
        route: "{{Request::url()}}",
        path: "{{Request::path()}}",
        full_url: "{{Request::fullUrl() }}",
        name: "{{config('app.name')}}",
        description: "{{config('app.description')}}",
        author: "{{config('app.author')}}",
        author_url: "{{config('app.author_url')}}",
        locale: "{{config('app.locale')}}",
        timezone: "{{config('app.timezone')}}",
    };

    /**
     * Alias.
     */
    var log = console.log;
</script>
