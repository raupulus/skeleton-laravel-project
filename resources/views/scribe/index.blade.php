<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Skeleton Laravel Project API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost:8000";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.9.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.9.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-autenticacion" class="tocify-header">
                <li class="tocify-item level-1" data-unique="autenticacion">
                    <a href="#autenticacion">Autenticación</a>
                </li>
                                    <ul id="tocify-subheader-autenticacion" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v1-auth-register">
                                <a href="#autenticacion-POSTapi-v1-auth-register">Registra un nuevo usuario en la plataforma y devuelve su token de acceso.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v1-auth-login">
                                <a href="#autenticacion-POSTapi-v1-auth-login">Autentica al usuario con sus credenciales y devuelve un token de acceso.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v1-auth-forgot-password">
                                <a href="#autenticacion-POSTapi-v1-auth-forgot-password">Envía un enlace de restablecimiento de contraseña al email especificado.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v1-auth-reset-password">
                                <a href="#autenticacion-POSTapi-v1-auth-reset-password">Restablece la contraseña del usuario usando el token de restablecimiento.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v1-auth-logout">
                                <a href="#autenticacion-POSTapi-v1-auth-logout">Revoca el token de acceso actual del usuario autenticado.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-GETapi-v1-auth-user">
                                <a href="#autenticacion-GETapi-v1-auth-user">Devuelve los datos del usuario autenticado actualmente.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-categorias" class="tocify-header">
                <li class="tocify-item level-1" data-unique="categorias">
                    <a href="#categorias">Categorías</a>
                </li>
                                    <ul id="tocify-subheader-categorias" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="categorias-GETapi-v1-categories">
                                <a href="#categorias-GETapi-v1-categories">Devuelve el listado completo de categorías activas ordenadas por orden.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="categorias-GETapi-v1-categories--slug-">
                                <a href="#categorias-GETapi-v1-categories--slug-">Devuelve el detalle de una categoría específica identificada por su slug.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-posts" class="tocify-header">
                <li class="tocify-item level-1" data-unique="posts">
                    <a href="#posts">Posts</a>
                </li>
                                    <ul id="tocify-subheader-posts" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="posts-GETapi-v1-posts">
                                <a href="#posts-GETapi-v1-posts">Devuelve un listado paginado de posts publicados y activos.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="posts-GETapi-v1-posts--slug-">
                                <a href="#posts-GETapi-v1-posts--slug-">Devuelve el detalle de un post específico identificado por su slug.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-paginas" class="tocify-header">
                <li class="tocify-item level-1" data-unique="paginas">
                    <a href="#paginas">Páginas</a>
                </li>
                                    <ul id="tocify-subheader-paginas" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="paginas-GETapi-v1-pages">
                                <a href="#paginas-GETapi-v1-pages">Devuelve un listado paginado de páginas publicadas y activas.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="paginas-GETapi-v1-pages--slug-">
                                <a href="#paginas-GETapi-v1-pages--slug-">Devuelve el detalle de una página específica identificada por su slug.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-tokens-de-api" class="tocify-header">
                <li class="tocify-item level-1" data-unique="tokens-de-api">
                    <a href="#tokens-de-api">Tokens de API</a>
                </li>
                                    <ul id="tocify-subheader-tokens-de-api" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="tokens-de-api-GETapi-v1-user-tokens">
                                <a href="#tokens-de-api-GETapi-v1-user-tokens">Lista todos los tokens de API del usuario autenticado.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tokens-de-api-POSTapi-v1-user-tokens">
                                <a href="#tokens-de-api-POSTapi-v1-user-tokens">Crea un nuevo token de API para el usuario autenticado.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tokens-de-api-DELETEapi-v1-user-tokens--tokenId-">
                                <a href="#tokens-de-api-DELETEapi-v1-user-tokens--tokenId-">Elimina un token de API específico del usuario autenticado.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: May 12, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="autenticacion">Autenticación</h1>

    

                                <h2 id="autenticacion-POSTapi-v1-auth-register">Registra un nuevo usuario en la plataforma y devuelve su token de acceso.</h2>

<p>
</p>

<p>Envía un email de bienvenida tras el registro exitoso.</p>

<span id="example-requests-POSTapi-v1-auth-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/auth/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\",
    \"email\": \"zbailey@example.net\",
    \"password\": \"-0pBNvYgxw\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/auth/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b",
    "email": "zbailey@example.net",
    "password": "-0pBNvYgxw"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-register">
</span>
<span id="execution-results-POSTapi-v1-auth-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-register" data-method="POST"
      data-path="api/v1/auth/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-register"
                    onclick="tryItOut('POSTapi-v1-auth-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-register"
                    onclick="cancelTryOut('POSTapi-v1-auth-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-auth-register"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-auth-register"
               value="zbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Must not be greater than 255 characters. Example: <code>zbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-auth-register"
               value="-0pBNvYgxw"
               data-component="body">
    <br>
<p>Must be at least 8 characters. Example: <code>-0pBNvYgxw</code></p>
        </div>
        </form>

                    <h2 id="autenticacion-POSTapi-v1-auth-login">Autentica al usuario con sus credenciales y devuelve un token de acceso.</h2>

<p>
</p>

<p>Verifica también que el usuario esté activo en la plataforma.</p>

<span id="example-requests-POSTapi-v1-auth-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/auth/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"gbailey@example.net\",
    \"password\": \"|]|{+-\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/auth/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "gbailey@example.net",
    "password": "|]|{+-"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-login">
</span>
<span id="execution-results-POSTapi-v1-auth-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-login" data-method="POST"
      data-path="api/v1/auth/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-login"
                    onclick="tryItOut('POSTapi-v1-auth-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-login"
                    onclick="cancelTryOut('POSTapi-v1-auth-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-auth-login"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-auth-login"
               value="|]|{+-"
               data-component="body">
    <br>
<p>Example: <code>|]|{+-</code></p>
        </div>
        </form>

                    <h2 id="autenticacion-POSTapi-v1-auth-forgot-password">Envía un enlace de restablecimiento de contraseña al email especificado.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-auth-forgot-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/auth/forgot-password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"gbailey@example.net\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/auth/forgot-password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "gbailey@example.net"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-forgot-password">
</span>
<span id="execution-results-POSTapi-v1-auth-forgot-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-forgot-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-forgot-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-forgot-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-forgot-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-forgot-password" data-method="POST"
      data-path="api/v1/auth/forgot-password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-forgot-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-forgot-password"
                    onclick="tryItOut('POSTapi-v1-auth-forgot-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-forgot-password"
                    onclick="cancelTryOut('POSTapi-v1-auth-forgot-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-forgot-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/forgot-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-forgot-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-forgot-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-auth-forgot-password"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. The <code>email</code> of an existing record in the users table. Example: <code>gbailey@example.net</code></p>
        </div>
        </form>

                    <h2 id="autenticacion-POSTapi-v1-auth-reset-password">Restablece la contraseña del usuario usando el token de restablecimiento.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-auth-reset-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/auth/reset-password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"token\": \"architecto\",
    \"email\": \"zbailey@example.net\",
    \"password\": \"-0pBNvYgxw\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/auth/reset-password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "token": "architecto",
    "email": "zbailey@example.net",
    "password": "-0pBNvYgxw"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-reset-password">
</span>
<span id="execution-results-POSTapi-v1-auth-reset-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-reset-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-reset-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-reset-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-reset-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-reset-password" data-method="POST"
      data-path="api/v1/auth/reset-password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-reset-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-reset-password"
                    onclick="tryItOut('POSTapi-v1-auth-reset-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-reset-password"
                    onclick="cancelTryOut('POSTapi-v1-auth-reset-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-reset-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/reset-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-reset-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-reset-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="token"                data-endpoint="POSTapi-v1-auth-reset-password"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-auth-reset-password"
               value="zbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>zbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-auth-reset-password"
               value="-0pBNvYgxw"
               data-component="body">
    <br>
<p>Must be at least 8 characters. Example: <code>-0pBNvYgxw</code></p>
        </div>
        </form>

                    <h2 id="autenticacion-POSTapi-v1-auth-logout">Revoca el token de acceso actual del usuario autenticado.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-auth-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/auth/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/auth/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-logout">
</span>
<span id="execution-results-POSTapi-v1-auth-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-logout" data-method="POST"
      data-path="api/v1/auth/logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-logout"
                    onclick="tryItOut('POSTapi-v1-auth-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-logout"
                    onclick="cancelTryOut('POSTapi-v1-auth-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="autenticacion-GETapi-v1-auth-user">Devuelve los datos del usuario autenticado actualmente.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-auth-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/auth/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/auth/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-auth-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
x-xss-protection: 1; mode=block
referrer-policy: strict-origin-when-cross-origin
permissions-policy: camera=(), microphone=(), geolocation=()
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-auth-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-auth-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-auth-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-auth-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-auth-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-auth-user" data-method="GET"
      data-path="api/v1/auth/user"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-auth-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-auth-user"
                    onclick="tryItOut('GETapi-v1-auth-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-auth-user"
                    onclick="cancelTryOut('GETapi-v1-auth-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-auth-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/auth/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-auth-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-auth-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="categorias">Categorías</h1>

    

                                <h2 id="categorias-GETapi-v1-categories">Devuelve el listado completo de categorías activas ordenadas por orden.</h2>

<p>
</p>

<p>Las categorías no se paginan ya que su número suele ser reducido.</p>

<span id="example-requests-GETapi-v1-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/categories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-categories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 49
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
x-xss-protection: 1; mode=block
referrer-policy: strict-origin-when-cross-origin
permissions-policy: camera=(), microphone=(), geolocation=()
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;id&quot;: 6,
        &quot;slug&quot;: &quot;oooooo&quot;,
        &quot;name&quot;: {
            &quot;es&quot;: &quot;oooo&quot;
        },
        &quot;description&quot;: {
            &quot;es&quot;: &quot;oooo&quot;
        },
        &quot;image&quot;: null,
        &quot;is_active&quot;: true,
        &quot;order&quot;: 0,
        &quot;created_at&quot;: &quot;2026-05-12T10:54:45.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-05-12T10:54:45.000000Z&quot;,
        &quot;deleted_at&quot;: null
    },
    {
        &quot;id&quot;: 1,
        &quot;slug&quot;: &quot;documentacion&quot;,
        &quot;name&quot;: {
            &quot;en&quot;: &quot;Documentation&quot;,
            &quot;es&quot;: &quot;Documentaci&oacute;n&quot;
        },
        &quot;description&quot;: {
            &quot;en&quot;: &quot;Guides and project skeleton documentation.&quot;,
            &quot;es&quot;: &quot;Gu&iacute;as y documentaci&oacute;n del proyecto skeleton.&quot;
        },
        &quot;image&quot;: &quot;categories/01KRDYRY6GWJVRE3BAEAC1EV4Z.png&quot;,
        &quot;is_active&quot;: true,
        &quot;order&quot;: 1,
        &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-05-12T11:22:22.000000Z&quot;,
        &quot;deleted_at&quot;: null
    },
    {
        &quot;id&quot;: 2,
        &quot;slug&quot;: &quot;desarrollo&quot;,
        &quot;name&quot;: {
            &quot;en&quot;: &quot;Development&quot;,
            &quot;es&quot;: &quot;Desarrollo&quot;
        },
        &quot;description&quot;: {
            &quot;en&quot;: &quot;Articles about development with the project stack.&quot;,
            &quot;es&quot;: &quot;Art&iacute;culos sobre desarrollo con el stack del proyecto.&quot;
        },
        &quot;image&quot;: null,
        &quot;is_active&quot;: true,
        &quot;order&quot;: 2,
        &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
        &quot;deleted_at&quot;: null
    },
    {
        &quot;id&quot;: 3,
        &quot;slug&quot;: &quot;despliegue&quot;,
        &quot;name&quot;: {
            &quot;en&quot;: &quot;Deployment&quot;,
            &quot;es&quot;: &quot;Despliegue&quot;
        },
        &quot;description&quot;: {
            &quot;en&quot;: &quot;Docker and production deployment guides.&quot;,
            &quot;es&quot;: &quot;Gu&iacute;as de despliegue en Docker y producci&oacute;n.&quot;
        },
        &quot;image&quot;: null,
        &quot;is_active&quot;: true,
        &quot;order&quot;: 3,
        &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
        &quot;deleted_at&quot;: null
    },
    {
        &quot;id&quot;: 4,
        &quot;slug&quot;: &quot;tecnologia&quot;,
        &quot;name&quot;: {
            &quot;en&quot;: &quot;Technology&quot;,
            &quot;es&quot;: &quot;Tecnolog&iacute;a&quot;
        },
        &quot;description&quot;: {
            &quot;en&quot;: &quot;Technology articles.&quot;,
            &quot;es&quot;: &quot;Art&iacute;culos sobre tecnolog&iacute;a.&quot;
        },
        &quot;image&quot;: null,
        &quot;is_active&quot;: true,
        &quot;order&quot;: 4,
        &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
        &quot;deleted_at&quot;: null
    },
    {
        &quot;id&quot;: 5,
        &quot;slug&quot;: &quot;tutoriales&quot;,
        &quot;name&quot;: {
            &quot;en&quot;: &quot;Tutorials&quot;,
            &quot;es&quot;: &quot;Tutoriales&quot;
        },
        &quot;description&quot;: {
            &quot;en&quot;: &quot;Guides and tutorials.&quot;,
            &quot;es&quot;: &quot;Gu&iacute;as y tutoriales.&quot;
        },
        &quot;image&quot;: null,
        &quot;is_active&quot;: true,
        &quot;order&quot;: 5,
        &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
        &quot;deleted_at&quot;: null
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-categories" data-method="GET"
      data-path="api/v1/categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-categories"
                    onclick="tryItOut('GETapi-v1-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-categories"
                    onclick="cancelTryOut('GETapi-v1-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="categorias-GETapi-v1-categories--slug-">Devuelve el detalle de una categoría específica identificada por su slug.</h2>

<p>
</p>

<p>Devuelve 404 si la categoría no existe o no está activa.</p>

<span id="example-requests-GETapi-v1-categories--slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/categories/2" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/categories/2"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-categories--slug-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 48
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
x-xss-protection: 1; mode=block
referrer-policy: strict-origin-when-cross-origin
permissions-policy: camera=(), microphone=(), geolocation=()
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Category].&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-categories--slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-categories--slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-categories--slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-categories--slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-categories--slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-categories--slug-" data-method="GET"
      data-path="api/v1/categories/{slug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-categories--slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-categories--slug-"
                    onclick="tryItOut('GETapi-v1-categories--slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-categories--slug-"
                    onclick="cancelTryOut('GETapi-v1-categories--slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-categories--slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/categories/{slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-categories--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-categories--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="slug"                data-endpoint="GETapi-v1-categories--slug-"
               value="2"
               data-component="url">
    <br>
<p>The slug of the category. Example: <code>2</code></p>
            </div>
                    </form>

                <h1 id="posts">Posts</h1>

    

                                <h2 id="posts-GETapi-v1-posts">Devuelve un listado paginado de posts publicados y activos.</h2>

<p>
</p>

<p>Soporta paginación con parámetro per_page (máximo 50 por página).</p>

<span id="example-requests-GETapi-v1-posts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/posts" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/posts"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-posts">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 53
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
x-xss-protection: 1; mode=block
referrer-policy: strict-origin-when-cross-origin
permissions-policy: camera=(), microphone=(), geolocation=()
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 10,
            &quot;slug&quot;: &quot;vue3-alpinejs-frontend&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Vue 3 and Alpine.js in the frontend&quot;,
                &quot;es&quot;: &quot;Vue 3 y Alpine.js en el frontend&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;Vue 3: ready but not active by default&lt;/h2&gt;&lt;p&gt;Integrated via Vite. Mount point: &lt;code&gt;&amp;lt;div id=\&quot;vue-app\&quot;&amp;gt;&lt;/code&gt;.&lt;/p&gt;&lt;h2&gt;Alpine.js for light interactivity&lt;/h2&gt;&lt;p&gt;Already loaded. Recommended for simple toggles, dropdowns and animations.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;Vue 3: preparado, no activo por defecto&lt;/h2&gt;&lt;p&gt;Vue 3 est&aacute; integrado v&iacute;a Vite pero no se usa en producci&oacute;n a&uacute;n. El punto de montaje en el home es &lt;code&gt;&amp;lt;div id=\&quot;vue-app\&quot;&amp;gt;&lt;/code&gt;.&lt;/p&gt;&lt;h2&gt;A&ntilde;adir un componente Vue&lt;/h2&gt;&lt;p&gt;1. Crea &lt;code&gt;resources/js/components/MiComponente.vue&lt;/code&gt;:&lt;/p&gt;&lt;pre&gt;&lt;code&gt;&amp;lt;template&amp;gt;\\n  &amp;lt;div&amp;gt;&amp;lt;button @click=\&quot;count++\&quot;&amp;gt;&amp;#123;&amp;#123; count &amp;#125;&amp;#125;&amp;lt;/button&amp;gt;&amp;lt;/div&amp;gt;\\n&amp;lt;/template&amp;gt;\\n&amp;lt;script setup&amp;gt;\\nimport { ref } from &#039;vue&#039;\\nconst count = ref(0)\\n&amp;lt;/script&amp;gt;&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;2. Reg&iacute;stralo en &lt;code&gt;resources/js/app.js&lt;/code&gt;:&lt;/p&gt;&lt;pre&gt;&lt;code&gt;import MiComponente from &#039;./components/MiComponente.vue&#039;\\napp.component(&#039;mi-componente&#039;, MiComponente)&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;3. &Uacute;salo en Blade dentro de &lt;code&gt;#vue-app&lt;/code&gt;:&lt;/p&gt;&lt;pre&gt;&lt;code&gt;&amp;lt;div id=\&quot;vue-app\&quot;&amp;gt;&amp;lt;mi-componente /&amp;gt;&amp;lt;/div&amp;gt;&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Alpine.js para interactividad ligera&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;&amp;lt;!-- Toggle --&amp;gt;\\n&amp;lt;div x-data=\&quot;{ open: false }\&quot;&amp;gt;\\n  &amp;lt;button @click=\&quot;open = !open\&quot;&amp;gt;Toggle&amp;lt;/button&amp;gt;\\n  &amp;lt;div x-show=\&quot;open\&quot;&amp;gt;Contenido&amp;lt;/div&amp;gt;\\n&amp;lt;/div&amp;gt;&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;&iquest;Cu&aacute;ndo usar cada uno?&lt;/h2&gt;&lt;table&gt;&lt;thead&gt;&lt;tr&gt;&lt;th&gt;Caso de uso&lt;/th&gt;&lt;th&gt;Recomendaci&oacute;n&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;Toggle, dropdown, modals simples&lt;/td&gt;&lt;td&gt;Alpine.js&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;Formularios reactivos complejos&lt;/td&gt;&lt;td&gt;Vue 3&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;Componentes con estado complejo&lt;/td&gt;&lt;td&gt;Vue 3&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;How to add Vue 3 components to the Blade frontend and when to use Alpine.js for light interactivity.&quot;,
                &quot;es&quot;: &quot;C&oacute;mo a&ntilde;adir componentes Vue 3 al frontend Blade y cu&aacute;ndo usar Alpine.js para interactividad ligera.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Vue 3 and Alpine.js in the Laravel frontend&quot;,
                &quot;es&quot;: &quot;Vue 3 y Alpine.js en el frontend Laravel&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;How to use Vue 3 and Alpine.js in the project: when to use each, adding components and mount points.&quot;,
                &quot;es&quot;: &quot;C&oacute;mo usar Vue 3 y Alpine.js en el proyecto: cu&aacute;ndo usar cada uno, a&ntilde;adir componentes y puntos de montaje.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-01T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-12T18:21:26.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;desarrollo&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Development&quot;,
                        &quot;es&quot;: &quot;Desarrollo&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 10,
                        &quot;category_id&quot;: 2
                    }
                }
            ]
        },
        {
            &quot;id&quot;: 9,
            &quot;slug&quot;: &quot;sistema-autenticacion-web-api&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Authentication system: Web and API&quot;,
                &quot;es&quot;: &quot;Sistema de autenticaci&oacute;n: Web y API&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;Roles (PHP 8.4 Backed Enum)&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;enum Role: string { case SuperAdmin = &#039;superadmin&#039;; case Admin = &#039;admin&#039;; case User = &#039;user&#039;; }&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Panel access&lt;/h2&gt;&lt;p&gt;User model implements &lt;code&gt;canAccessPanel(Panel $panel)&lt;/code&gt; to control access to each panel.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;Autenticaci&oacute;n web (Laravel Breeze)&lt;/h2&gt;&lt;p&gt;Rutas en &lt;code&gt;routes/auth.php&lt;/code&gt;: login, register, logout, forgot-password, reset-password, verify-email.&lt;/p&gt;&lt;h2&gt;Roles de usuario (Enum PHP 8.4)&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;enum Role: string\\n{\\n    case SuperAdmin = &#039;superadmin&#039;;\\n    case Admin      = &#039;admin&#039;;\\n    case User       = &#039;user&#039;;\\n}\\n\\n// Comprobaci&oacute;n\\nif ($user-&gt;role === Role::Admin) { ... }&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Acceso a paneles Filament&lt;/h2&gt;&lt;p&gt;El modelo &lt;code&gt;User&lt;/code&gt; implementa &lt;code&gt;canAccessPanel(Panel $panel)&lt;/code&gt;:&lt;/p&gt;&lt;ul&gt;&lt;li&gt;&lt;strong&gt;Panel Admin&lt;/strong&gt;: solo &lt;code&gt;superadmin&lt;/code&gt; y &lt;code&gt;admin&lt;/code&gt;&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Panel Usuario&lt;/strong&gt;: cualquier usuario con &lt;code&gt;is_active = true&lt;/code&gt;&lt;/li&gt;&lt;/ul&gt;&lt;h2&gt;Pol&iacute;ticas de autorizaci&oacute;n&lt;/h2&gt;&lt;p&gt;Cada modelo tiene su Policy en &lt;code&gt;app/Policies/&lt;/code&gt;. Patr&oacute;n: solo admins pueden crear/editar/eliminar:&lt;/p&gt;&lt;pre&gt;&lt;code&gt;public function create(User $user): bool\\n{\\n    return in_array($user-&gt;role, [Role::Admin, Role::SuperAdmin]);\\n}&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Autenticaci&oacute;n API con Sanctum&lt;/h2&gt;&lt;p&gt;Ver el post &lt;em&gt;API REST con Laravel Sanctum&lt;/em&gt; para el flujo completo de obtenci&oacute;n y uso de tokens.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;How authentication works in the project: Laravel Breeze for web, Sanctum for API, user roles and access policies.&quot;,
                &quot;es&quot;: &quot;C&oacute;mo funciona la autenticaci&oacute;n en el proyecto: Laravel Breeze para web, Sanctum para API, roles de usuario y pol&iacute;ticas de acceso.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Web and API authentication with Sanctum&quot;,
                &quot;es&quot;: &quot;Autenticaci&oacute;n web y API con Sanctum&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Project authentication system: Breeze, Sanctum, PHP enum roles and access policies.&quot;,
                &quot;es&quot;: &quot;Sistema de autenticaci&oacute;n del proyecto: Breeze, Sanctum, roles PHP enum y pol&iacute;ticas de acceso.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-04-29T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;desarrollo&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Development&quot;,
                        &quot;es&quot;: &quot;Desarrollo&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 9,
                        &quot;category_id&quot;: 2
                    }
                },
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;documentacion&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Documentation&quot;,
                        &quot;es&quot;: &quot;Documentaci&oacute;n&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 9,
                        &quot;category_id&quot;: 1
                    }
                }
            ]
        },
        {
            &quot;id&quot;: 8,
            &quot;slug&quot;: &quot;comandos-artisan-personalizados&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Custom Artisan commands&quot;,
                &quot;es&quot;: &quot;Comandos Artisan personalizados del proyecto&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;project:install&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;php artisan project:install --force&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;project:clear&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;php artisan project:clear&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;sitemap:generate&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;php artisan sitemap:generate&lt;/code&gt;&lt;/pre&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;project:install&lt;/h2&gt;&lt;p&gt;Instala y configura el proyecto desde cero con confirmaciones interactivas.&lt;/p&gt;&lt;pre&gt;&lt;code&gt;php artisan project:install\\n# O sin confirmaciones (CI/CD o Docker):\\nphp artisan project:install --force&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;Ejecuta: key:generate &rarr; storage:link &rarr; migrate &rarr; db:seed &rarr; cache:clear &rarr; npm run build (opcional).&lt;/p&gt;&lt;h2&gt;project:clear&lt;/h2&gt;&lt;p&gt;Limpia toda la cach&eacute;. &Uacute;til tras subir cambios al servidor.&lt;/p&gt;&lt;pre&gt;&lt;code&gt;php artisan project:clear&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;Limpia: config, rutas, vistas compiladas, cach&eacute; de aplicaci&oacute;n y eventos.&lt;/p&gt;&lt;h2&gt;sitemap:generate&lt;/h2&gt;&lt;p&gt;Genera &lt;code&gt;public/sitemap.xml&lt;/code&gt; con todas las URLs p&uacute;blicas.&lt;/p&gt;&lt;pre&gt;&lt;code&gt;php artisan sitemap:generate&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;Se puede programar en &lt;code&gt;routes/console.php&lt;/code&gt;:&lt;/p&gt;&lt;pre&gt;&lt;code&gt;Schedule::command(&#039;sitemap:generate&#039;)-&gt;daily();&lt;/code&gt;&lt;/pre&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;The three project artisan commands: project:install, project:clear and sitemap:generate. When to use them and what they do exactly.&quot;,
                &quot;es&quot;: &quot;Los tres comandos artisan del proyecto: project:install, project:clear y sitemap:generate. Cu&aacute;ndo usarlos y qu&eacute; hacen exactamente.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Project Artisan commands: install, clear, sitemap&quot;,
                &quot;es&quot;: &quot;Comandos Artisan del proyecto: install, clear, sitemap&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Project artisan commands reference: what they do, when to use them and how to schedule them.&quot;,
                &quot;es&quot;: &quot;Referencia de los comandos artisan del proyecto: qu&eacute; hacen, cu&aacute;ndo usarlos y c&oacute;mo programarlos.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-04-27T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;desarrollo&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Development&quot;,
                        &quot;es&quot;: &quot;Desarrollo&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 8,
                        &quot;category_id&quot;: 2
                    }
                },
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;documentacion&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Documentation&quot;,
                        &quot;es&quot;: &quot;Documentaci&oacute;n&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 8,
                        &quot;category_id&quot;: 1
                    }
                }
            ]
        },
        {
            &quot;id&quot;: 7,
            &quot;slug&quot;: &quot;settings-dinamicos-helper-global&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Dynamic settings and global helper setting()&quot;,
                &quot;es&quot;: &quot;Settings din&aacute;micos y helper global setting()&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;What are Settings?&lt;/h2&gt;&lt;p&gt;Key-value pairs in the &lt;code&gt;settings&lt;/code&gt; table for configuring the site without touching code.&lt;/p&gt;&lt;h2&gt;Global helper&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;setting(&#039;site_title&#039;, &#039;My Site&#039;);\\n// In Blade:\\n&amp;#123;&amp;#123; setting(&#039;contact_email&#039;) &amp;#125;&amp;#125;&lt;/code&gt;&lt;/pre&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;&iquest;Qu&eacute; son los Settings?&lt;/h2&gt;&lt;p&gt;Son pares key-value en la tabla &lt;code&gt;settings&lt;/code&gt; para configurar el sitio sin tocar c&oacute;digo: t&iacute;tulo, redes sociales, email de contacto, Google Analytics ID...&lt;/p&gt;&lt;h2&gt;Helper global&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;// En un controlador, servicio o vista Blade\\n$title = setting(&#039;site_title&#039;, &#039;Mi Sitio Web&#039;);\\n// En Blade:\\n&amp;#123;&amp;#123; setting(&#039;contact_email&#039;, &#039;&#039;) &amp;#125;&amp;#125;&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Settings disponibles por defecto&lt;/h2&gt;&lt;table&gt;&lt;thead&gt;&lt;tr&gt;&lt;th&gt;Key&lt;/th&gt;&lt;th&gt;Grupo&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;site_title&lt;/td&gt;&lt;td&gt;general&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;site_description&lt;/td&gt;&lt;td&gt;general&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;contact_email&lt;/td&gt;&lt;td&gt;contact&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;facebook_url&lt;/td&gt;&lt;td&gt;social&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;google_analytics_id&lt;/td&gt;&lt;td&gt;seo&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;h2&gt;Cach&eacute; autom&aacute;tica&lt;/h2&gt;&lt;p&gt;El &lt;code&gt;SettingService&lt;/code&gt; cachea los settings 1 hora. Invalida la cach&eacute; manualmente con:&lt;/p&gt;&lt;pre&gt;&lt;code&gt;php artisan cache:clear&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;A&ntilde;adir un nuevo setting en el seeder&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;Setting::firstOrCreate(\\n    [&#039;key&#039; =&gt; &#039;whatsapp_url&#039;],\\n    [&#039;display_name&#039; =&gt; &#039;WhatsApp URL&#039;, &#039;value&#039; =&gt; &#039;&#039;, &#039;type&#039; =&gt; &#039;text&#039;, &#039;group&#039; =&gt; &#039;social&#039;]\\n);&lt;/code&gt;&lt;/pre&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;How to use the dynamic configuration system: the setting() helper, automatic caching and how to add new keys from Filament.&quot;,
                &quot;es&quot;: &quot;C&oacute;mo usar el sistema de configuraci&oacute;n din&aacute;mica: el helper setting(), la cach&eacute; autom&aacute;tica y c&oacute;mo a&ntilde;adir nuevas keys desde Filament.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Dynamic settings system and setting() helper&quot;,
                &quot;es&quot;: &quot;Sistema de settings din&aacute;micos y helper setting()&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Settings system guide: global helper, caching, available keys and how to add new configurations.&quot;,
                &quot;es&quot;: &quot;Gu&iacute;a del sistema de settings: helper global, cach&eacute;, keys disponibles y c&oacute;mo a&ntilde;adir nuevas configuraciones.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-04-25T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-12T18:21:26.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;documentacion&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Documentation&quot;,
                        &quot;es&quot;: &quot;Documentaci&oacute;n&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 7,
                        &quot;category_id&quot;: 1
                    }
                }
            ]
        },
        {
            &quot;id&quot;: 6,
            &quot;slug&quot;: &quot;despliegue-produccion-nginx&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Production deployment with Nginx&quot;,
                &quot;es&quot;: &quot;Despliegue en producci&oacute;n con Nginx&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;Server requirements&lt;/h2&gt;&lt;ul&gt;&lt;li&gt;Ubuntu 22.04, PHP 8.4, PostgreSQL 16, Nginx, Certbot&lt;/li&gt;&lt;/ul&gt;&lt;h2&gt;Deployment&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;git pull origin main\\ncomposer install --no-dev --optimize-autoloader\\nnpm ci &amp;amp;&amp;amp; npm run build\\nphp artisan migrate --force\\nphp artisan optimize&lt;/code&gt;&lt;/pre&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;Requisitos del servidor&lt;/h2&gt;&lt;ul&gt;&lt;li&gt;Ubuntu 22.04 / Debian 12&lt;/li&gt;&lt;li&gt;PHP 8.4 con extensiones: pdo_pgsql, mbstring, xml, curl, zip, gd&lt;/li&gt;&lt;li&gt;PostgreSQL 16, Nginx, Certbot (SSL)&lt;/li&gt;&lt;li&gt;Composer 2, Node.js 20, npm&lt;/li&gt;&lt;/ul&gt;&lt;h2&gt;Configuraci&oacute;n Nginx&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;sudo cp docs/deploys/nginx.conf /etc/nginx/sites-available/mi-proyecto\\nsudo ln -s /etc/nginx/sites-available/mi-proyecto /etc/nginx/sites-enabled/\\nsudo nginx -t &amp;amp;&amp;amp; sudo systemctl reload nginx&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Variables de entorno para producci&oacute;n&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;APP_ENV=production\\nAPP_DEBUG=false\\nAPP_URL=https://tudominio.com\\nCACHE_STORE=redis\\nQUEUE_CONNECTION=redis\\nSESSION_DRIVER=redis&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Proceso de despliegue&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;git pull origin main\\ncomposer install --no-dev --optimize-autoloader\\nnpm ci &amp;amp;&amp;amp; npm run build\\nphp artisan migrate --force\\nphp artisan project:clear\\nphp artisan optimize\\nphp artisan sitemap:generate\\nsudo systemctl restart php8.4-fpm&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Script automatizado&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;bash docs/deploys/deploy.sh&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Cola de trabajos en producci&oacute;n&lt;/h2&gt;&lt;p&gt;Se recomienda Redis como driver de cola. Configura un servicio systemd para el worker que se reinicie autom&aacute;ticamente.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;Guide to deploy on a VPS with Nginx, configure SSL, optimize Laravel for production and automate deployment.&quot;,
                &quot;es&quot;: &quot;Gu&iacute;a para desplegar en un VPS con Nginx, configurar SSL, optimizar Laravel para producci&oacute;n y automatizar el deploy.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: true,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Production deployment with Nginx and PHP 8.4&quot;,
                &quot;es&quot;: &quot;Despliegue en producci&oacute;n con Nginx y PHP 8.4&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Complete production deployment guide: Nginx, environment variables, Laravel optimization and deploy scripts.&quot;,
                &quot;es&quot;: &quot;Gu&iacute;a completa para desplegar en producci&oacute;n: Nginx, variables de entorno, optimizaci&oacute;n Laravel y scripts de deploy.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-04-23T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 3,
                    &quot;slug&quot;: &quot;despliegue&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Deployment&quot;,
                        &quot;es&quot;: &quot;Despliegue&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 6,
                        &quot;category_id&quot;: 3
                    }
                }
            ]
        },
        {
            &quot;id&quot;: 5,
            &quot;slug&quot;: &quot;despliegue-docker-laravel&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Docker deployment&quot;,
                &quot;es&quot;: &quot;Despliegue con Docker&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;Services&lt;/h2&gt;&lt;ul&gt;&lt;li&gt;&lt;strong&gt;app&lt;/strong&gt;: PHP 8.4 FPM&lt;/li&gt;&lt;li&gt;&lt;strong&gt;nginx&lt;/strong&gt;: Web server&lt;/li&gt;&lt;li&gt;&lt;strong&gt;db&lt;/strong&gt;: PostgreSQL with persistent volume&lt;/li&gt;&lt;/ul&gt;&lt;h2&gt;Start in development&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;docker compose up -d\\ndocker compose exec app php artisan project:install --force&lt;/code&gt;&lt;/pre&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;Servicios incluidos&lt;/h2&gt;&lt;ul&gt;&lt;li&gt;&lt;strong&gt;app&lt;/strong&gt;: PHP 8.4 FPM con todas las extensiones necesarias&lt;/li&gt;&lt;li&gt;&lt;strong&gt;nginx&lt;/strong&gt;: Servidor web, configuraci&oacute;n en &lt;code&gt;docker/nginx/&lt;/code&gt;&lt;/li&gt;&lt;li&gt;&lt;strong&gt;db&lt;/strong&gt;: PostgreSQL con volumen persistente&lt;/li&gt;&lt;/ul&gt;&lt;h2&gt;Iniciar en desarrollo&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;cp .env.example .env\\n# Editar .env: DB_HOST=db\\ndocker compose up -d\\ndocker compose exec app php artisan project:install --force&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Variables de entorno para Docker&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;APP_URL=http://localhost:8080\\nDB_CONNECTION=pgsql\\nDB_HOST=db\\nDB_PORT=5432\\nDB_DATABASE=laravel\\nDB_USERNAME=laravel\\nDB_PASSWORD=secret&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Comandos artisan en Docker&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;docker compose exec app php artisan migrate\\ndocker compose exec app php artisan db:seed\\ndocker compose exec app php artisan queue:work&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Storage persistente&lt;/h2&gt;&lt;p&gt;El directorio &lt;code&gt;storage/app/&lt;/code&gt; est&aacute; montado como volumen para que los archivos subidos persistan entre reinicios del contenedor.&lt;/p&gt;&lt;h2&gt;Reconstruir contenedores&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;docker compose build --no-cache app\\ndocker compose down\\n# Eliminar tambi&eacute;n vol&uacute;menes (&iexcl;borra datos de BD!)\\ndocker compose down -v&lt;/code&gt;&lt;/pre&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;How to run the project with Docker in development and prepare it for production using docker-compose.&quot;,
                &quot;es&quot;: &quot;C&oacute;mo levantar el proyecto con Docker en desarrollo y prepararlo para producci&oacute;n usando docker-compose.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: true,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Docker Deployment &mdash; Step by step guide&quot;,
                &quot;es&quot;: &quot;Despliegue con Docker &mdash; Gu&iacute;a paso a paso&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;How to dockerize the Laravel project: services, environment variables, persistent storage and useful commands.&quot;,
                &quot;es&quot;: &quot;C&oacute;mo dockerizar el proyecto Laravel: servicios, variables de entorno, storage persistente y comandos &uacute;tiles.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-04-21T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 3,
                    &quot;slug&quot;: &quot;despliegue&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Deployment&quot;,
                        &quot;es&quot;: &quot;Despliegue&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 5,
                        &quot;category_id&quot;: 3
                    }
                }
            ]
        },
        {
            &quot;id&quot;: 4,
            &quot;slug&quot;: &quot;sistema-traducciones-spatie-translatable&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Translation system with Spatie Translatable&quot;,
                &quot;es&quot;: &quot;Sistema de traducciones con Spatie Translatable&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;Two translation levels&lt;/h2&gt;&lt;ol&gt;&lt;li&gt;&lt;strong&gt;Laravel language files&lt;/strong&gt;: Static UI texts.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;spatie/laravel-translatable&lt;/strong&gt;: Dynamic model content stored as JSON.&lt;/li&gt;&lt;/ol&gt;&lt;h2&gt;Usage&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;$post-&gt;getTranslation(&#039;title&#039;, app()-&gt;getLocale());&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;Change language by visiting &lt;code&gt;/lang/es&lt;/code&gt; or &lt;code&gt;/lang/en&lt;/code&gt;.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;Dos niveles de traducci&oacute;n&lt;/h2&gt;&lt;ol&gt;&lt;li&gt;&lt;strong&gt;Archivos de idioma Laravel&lt;/strong&gt; (&lt;code&gt;lang/es/&lt;/code&gt;, &lt;code&gt;lang/en/&lt;/code&gt;): Para textos est&aacute;ticos de la UI.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;spatie/laravel-translatable&lt;/strong&gt;: Para contenido din&aacute;mico en modelos (t&iacute;tulos, contenido de Posts, Pages, Sections, Slides, Categories).&lt;/li&gt;&lt;/ol&gt;&lt;h2&gt;Campos almacenados como JSON en la BD&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;// Columna title (tipo JSON) en la tabla posts:\\n{\&quot;es\&quot;: \&quot;Mi art&iacute;culo\&quot;, \&quot;en\&quot;: \&quot;My article\&quot;}&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Usar traducciones en c&oacute;digo&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;// Obtener traducci&oacute;n del locale actual\\n$post-&gt;getTranslation(&#039;title&#039;, app()-&gt;getLocale());\\n\\n// Guardar con traducci&oacute;n\\n$post-&gt;setTranslation(&#039;title&#039;, &#039;es&#039;, &#039;Mi t&iacute;tulo&#039;);\\n$post-&gt;setTranslation(&#039;title&#039;, &#039;en&#039;, &#039;My title&#039;);\\n$post-&gt;save();&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Usar traducciones en Blade&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;@{{-- Texto de interfaz (archivos lang/) --}}\\n@{{ __(&#039;messages.read_more&#039;) }}\\n\\n@{{-- Contenido de modelo traducible --}}\\n@{{ $post-&gt;getTranslation(&#039;title&#039;, app()-&gt;getLocale()) }}&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Cambiar idioma&lt;/h2&gt;&lt;p&gt;El usuario cambia el idioma visitando &lt;code&gt;/lang/es&lt;/code&gt; o &lt;code&gt;/lang/en&lt;/code&gt;. El middleware &lt;code&gt;SetLocale&lt;/code&gt; lo persiste en sesi&oacute;n.&lt;/p&gt;&lt;h2&gt;A&ntilde;adir campo traducible a un modelo&lt;/h2&gt;&lt;ol&gt;&lt;li&gt;En la migraci&oacute;n, usar &lt;code&gt;-&gt;json(&#039;campo&#039;)&lt;/code&gt;&lt;/li&gt;&lt;li&gt;En el modelo, a&ntilde;adir el campo al array &lt;code&gt;$translatable&lt;/code&gt;&lt;/li&gt;&lt;li&gt;En el Resource de Filament, usar tabs por idioma&lt;/li&gt;&lt;/ol&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;How translations work in Eloquent models, how to switch language in the frontend and how to manage language files.&quot;,
                &quot;es&quot;: &quot;C&oacute;mo funcionan las traducciones en los modelos Eloquent, c&oacute;mo cambiar el idioma en el frontend y c&oacute;mo gestionar los ficheros de idioma.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;ES/EN Translations with Spatie Translatable&quot;,
                &quot;es&quot;: &quot;Traducciones ES/EN con Spatie Translatable&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Complete translation system guide: language files, translatable models and language switching.&quot;,
                &quot;es&quot;: &quot;Gu&iacute;a completa del sistema de traducciones: archivos de idioma, modelos traducibles y cambio de idioma.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-04-19T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-12T17:54:40.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;documentacion&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Documentation&quot;,
                        &quot;es&quot;: &quot;Documentaci&oacute;n&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 4,
                        &quot;category_id&quot;: 1
                    }
                }
            ]
        },
        {
            &quot;id&quot;: 3,
            &quot;slug&quot;: &quot;api-rest-sanctum-documentacion&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;REST API with Laravel Sanctum&quot;,
                &quot;es&quot;: &quot;API REST con Laravel Sanctum&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;API Structure&lt;/h2&gt;&lt;p&gt;The API is versioned under &lt;code&gt;/api/v1&lt;/code&gt;. All controllers are in &lt;code&gt;app/Http/Controllers/Api/V1/&lt;/code&gt;.&lt;/p&gt;&lt;h2&gt;Authentication&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;curl -X POST /api/v1/auth/login \\\\n  -d &#039;{\&quot;email\&quot;:\&quot;admin@example.com\&quot;,\&quot;password\&quot;:\&quot;password\&quot;}&#039;&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;Generate docs: &lt;code&gt;php artisan scribe:generate&lt;/code&gt; &rarr; available at &lt;code&gt;/docs&lt;/code&gt;&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;Estructura de la API&lt;/h2&gt;&lt;p&gt;La API est&aacute; versionada bajo el prefijo &lt;code&gt;/api/v1&lt;/code&gt;. Todos los controladores est&aacute;n en &lt;code&gt;app/Http/Controllers/Api/V1/&lt;/code&gt;.&lt;/p&gt;&lt;h2&gt;Endpoints p&uacute;blicos (sin autenticaci&oacute;n)&lt;/h2&gt;&lt;table&gt;&lt;thead&gt;&lt;tr&gt;&lt;th&gt;M&eacute;todo&lt;/th&gt;&lt;th&gt;Endpoint&lt;/th&gt;&lt;th&gt;Descripci&oacute;n&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;GET&lt;/td&gt;&lt;td&gt;/api/v1/posts&lt;/td&gt;&lt;td&gt;Listado paginado de posts publicados&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;GET&lt;/td&gt;&lt;td&gt;/api/v1/posts/{slug}&lt;/td&gt;&lt;td&gt;Detalle de un post&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;GET&lt;/td&gt;&lt;td&gt;/api/v1/pages&lt;/td&gt;&lt;td&gt;Listado paginado de p&aacute;ginas&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;GET&lt;/td&gt;&lt;td&gt;/api/v1/pages/{slug}&lt;/td&gt;&lt;td&gt;Detalle de una p&aacute;gina&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;GET&lt;/td&gt;&lt;td&gt;/api/v1/categories&lt;/td&gt;&lt;td&gt;Listado de categor&iacute;as&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;POST&lt;/td&gt;&lt;td&gt;/api/v1/auth/register&lt;/td&gt;&lt;td&gt;Registro de nuevo usuario&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;POST&lt;/td&gt;&lt;td&gt;/api/v1/auth/login&lt;/td&gt;&lt;td&gt;Login &mdash; devuelve Bearer token&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;h2&gt;Endpoints autenticados (Bearer token requerido)&lt;/h2&gt;&lt;table&gt;&lt;thead&gt;&lt;tr&gt;&lt;th&gt;M&eacute;todo&lt;/th&gt;&lt;th&gt;Endpoint&lt;/th&gt;&lt;th&gt;Descripci&oacute;n&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;GET&lt;/td&gt;&lt;td&gt;/api/v1/auth/user&lt;/td&gt;&lt;td&gt;Datos del usuario autenticado&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;POST&lt;/td&gt;&lt;td&gt;/api/v1/auth/logout&lt;/td&gt;&lt;td&gt;Revoca el token actual&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;GET&lt;/td&gt;&lt;td&gt;/api/v1/user/tokens&lt;/td&gt;&lt;td&gt;Lista de tokens propios&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;POST&lt;/td&gt;&lt;td&gt;/api/v1/user/tokens&lt;/td&gt;&lt;td&gt;Crear nuevo token&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;DELETE&lt;/td&gt;&lt;td&gt;/api/v1/user/tokens/{id}&lt;/td&gt;&lt;td&gt;Eliminar un token&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;h2&gt;Autenticaci&oacute;n &mdash; Flujo completo&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;# 1. Obtener token\\ncurl -X POST /api/v1/auth/login \\\\n  -H \&quot;Content-Type: application/json\&quot; \\\\n  -d &#039;{\&quot;email\&quot;:\&quot;admin@example.com\&quot;,\&quot;password\&quot;:\&quot;password\&quot;}&#039;\\n\\n# Respuesta: {\&quot;token\&quot;: \&quot;1|abc123...\&quot;}\\n\\n# 2. Usar token en peticiones autenticadas\\ncurl -X GET /api/v1/auth/user \\\\n  -H \&quot;Authorization: Bearer 1|abc123...\&quot;&lt;/code&gt;&lt;/pre&gt;&lt;h2&gt;Documentaci&oacute;n con Scribe&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;php artisan scribe:generate&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;Disponible en &lt;code&gt;/docs&lt;/code&gt;.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;How to use the project REST API: available endpoints, authentication with Sanctum tokens and how to generate documentation with Scribe.&quot;,
                &quot;es&quot;: &quot;C&oacute;mo usar la API REST del proyecto: endpoints disponibles, autenticaci&oacute;n con tokens Sanctum y c&oacute;mo generar la documentaci&oacute;n con Scribe.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: true,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;REST API with Sanctum &mdash; Endpoints and authentication&quot;,
                &quot;es&quot;: &quot;API REST con Sanctum &mdash; Endpoints y autenticaci&oacute;n&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Complete REST API reference: public and authenticated endpoints, Sanctum tokens and Scribe documentation.&quot;,
                &quot;es&quot;: &quot;Referencia completa de la API REST: endpoints p&uacute;blicos y autenticados, tokens Sanctum y documentaci&oacute;n Scribe.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-04-16T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;desarrollo&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Development&quot;,
                        &quot;es&quot;: &quot;Desarrollo&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 3,
                        &quot;category_id&quot;: 2
                    }
                },
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;documentacion&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Documentation&quot;,
                        &quot;es&quot;: &quot;Documentaci&oacute;n&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 3,
                        &quot;category_id&quot;: 1
                    }
                }
            ]
        },
        {
            &quot;id&quot;: 2,
            &quot;slug&quot;: &quot;panel-administracion-filament&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Admin panel with Filament 5&quot;,
                &quot;es&quot;: &quot;Panel de administraci&oacute;n con Filament 5&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;Two separate panels&lt;/h2&gt;&lt;ul&gt;&lt;li&gt;&lt;strong&gt;Admin Panel &lt;code&gt;/admin&lt;/code&gt;&lt;/strong&gt;: Only for superadmin/admin roles.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;User Panel &lt;code&gt;/panel&lt;/code&gt;&lt;/strong&gt;: Any active user. Profile and API token management only.&lt;/li&gt;&lt;/ul&gt;&lt;h2&gt;Add a new Resource&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;php artisan make:filament-resource ModelName --generate&lt;/code&gt;&lt;/pre&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;Dos paneles separados&lt;/h2&gt;&lt;p&gt;El proyecto incluye dos paneles Filament con acceso independiente:&lt;/p&gt;&lt;ul&gt;&lt;li&gt;&lt;strong&gt;Panel Admin &lt;code&gt;/admin&lt;/code&gt;&lt;/strong&gt;: Solo para usuarios con rol &lt;code&gt;superadmin&lt;/code&gt; o &lt;code&gt;admin&lt;/code&gt; y &lt;code&gt;is_active = true&lt;/code&gt;. Gesti&oacute;n completa del sistema.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Panel Usuario &lt;code&gt;/panel&lt;/code&gt;&lt;/strong&gt;: Para cualquier usuario con &lt;code&gt;is_active = true&lt;/code&gt;. Solo puede editar su perfil y gestionar sus tokens API.&lt;/li&gt;&lt;/ul&gt;&lt;h2&gt;Recursos del Panel Admin&lt;/h2&gt;&lt;table&gt;&lt;thead&gt;&lt;tr&gt;&lt;th&gt;Resource&lt;/th&gt;&lt;th&gt;Navigation Group&lt;/th&gt;&lt;th&gt;Descripci&oacute;n&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;UserResource&lt;/td&gt;&lt;td&gt;Sistema&lt;/td&gt;&lt;td&gt;CRUD de usuarios con filtros por rol&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;PostResource&lt;/td&gt;&lt;td&gt;Contenido&lt;/td&gt;&lt;td&gt;Blog/art&iacute;culos con traducciones tabs&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;PageResource&lt;/td&gt;&lt;td&gt;Contenido&lt;/td&gt;&lt;td&gt;P&aacute;ginas est&aacute;ticas con traducciones&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;CategoryResource&lt;/td&gt;&lt;td&gt;Contenido&lt;/td&gt;&lt;td&gt;Categor&iacute;as compartidas&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;SlideResource&lt;/td&gt;&lt;td&gt;Media&lt;/td&gt;&lt;td&gt;Carruseles agrupados por zona&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;SectionResource&lt;/td&gt;&lt;td&gt;Frontend&lt;/td&gt;&lt;td&gt;Secciones din&aacute;micas por zona&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;SettingResource&lt;/td&gt;&lt;td&gt;Sistema&lt;/td&gt;&lt;td&gt;Configuraci&oacute;n key-value&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;SentEmailResource&lt;/td&gt;&lt;td&gt;Sistema&lt;/td&gt;&lt;td&gt;Historial de emails enviados (solo lectura)&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;h2&gt;C&oacute;mo a&ntilde;adir un nuevo Resource&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;php artisan make:filament-resource NombreModelo --generate&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;El resource se crea en &lt;code&gt;app/Filament/Admin/Resources/&lt;/code&gt;. Edita el Navigation Group en el m&eacute;todo &lt;code&gt;getNavigationGroup()&lt;/code&gt;.&lt;/p&gt;&lt;h2&gt;Campos traducibles en Filament&lt;/h2&gt;&lt;p&gt;Los modelos con &lt;code&gt;HasTranslations&lt;/code&gt; tienen tabs por idioma en sus formularios usando el componente &lt;code&gt;Tabs&lt;/code&gt; de Filament.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;How the admin panel is structured, what resources it includes, how to access it and how to extend it with new resources.&quot;,
                &quot;es&quot;: &quot;C&oacute;mo est&aacute; estructurado el panel admin, qu&eacute; recursos incluye, c&oacute;mo acceder y c&oacute;mo extenderlo con nuevos recursos.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: true,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Filament 5 Admin Panel &mdash; Complete Guide&quot;,
                &quot;es&quot;: &quot;Panel de administraci&oacute;n Filament 5 &mdash; Gu&iacute;a completa&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Admin panel usage guide: available resources, access, navigation groups and how to extend it.&quot;,
                &quot;es&quot;: &quot;Gu&iacute;a de uso del panel admin: recursos disponibles, acceso, grupos de navegaci&oacute;n y c&oacute;mo extenderlo.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-04-13T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;documentacion&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Documentation&quot;,
                        &quot;es&quot;: &quot;Documentaci&oacute;n&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 2,
                        &quot;category_id&quot;: 1
                    }
                }
            ]
        },
        {
            &quot;id&quot;: 1,
            &quot;slug&quot;: &quot;introduccion-skeleton-laravel-project&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Introduction to Skeleton Laravel Project&quot;,
                &quot;es&quot;: &quot;Introducci&oacute;n al Skeleton Laravel Project&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;h2&gt;What is Skeleton Laravel Project?&lt;/h2&gt;&lt;p&gt;It is a base template for Laravel projects that already has all common features implemented: web and API authentication, admin panel, content system, translations, SEO, Docker and more.&lt;/p&gt;&lt;h2&gt;Default credentials (seeders)&lt;/h2&gt;&lt;table&gt;&lt;thead&gt;&lt;tr&gt;&lt;th&gt;Email&lt;/th&gt;&lt;th&gt;Password&lt;/th&gt;&lt;th&gt;Role&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;admin@example.com&lt;/td&gt;&lt;td&gt;password&lt;/td&gt;&lt;td&gt;superadmin&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;h2&gt;Quick start&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;cp .env.example .env\\nphp artisan project:install&lt;/code&gt;&lt;/pre&gt;&quot;,
                &quot;es&quot;: &quot;&lt;h2&gt;&iquest;Qu&eacute; es el Skeleton Laravel Project?&lt;/h2&gt;&lt;p&gt;Es una plantilla base para proyectos Laravel que ya tiene implementadas todas las funcionalidades comunes: autenticaci&oacute;n web y API, panel de administraci&oacute;n, sistema de contenido, traducciones, SEO, Docker y m&aacute;s. El objetivo es que puedas empezar un nuevo proyecto sin dedicar semanas a configuraci&oacute;n y boilerplate.&lt;/p&gt;&lt;h2&gt;&iquest;Qu&eacute; incluye?&lt;/h2&gt;&lt;ul&gt;&lt;li&gt;&lt;strong&gt;PHP 8.4 + Laravel 13&lt;/strong&gt;: El stack m&aacute;s moderno, con typed properties, enums backed y return types en todos los m&eacute;todos.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Filament 5&lt;/strong&gt;: Dos paneles separados. &lt;code&gt;/admin&lt;/code&gt; para superadmin/admin y &lt;code&gt;/panel&lt;/code&gt; para usuarios registrados.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Autenticaci&oacute;n completa&lt;/strong&gt;: Web con Laravel Breeze y API con Sanctum. Roles: superadmin, admin, user.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Sistema de contenido&lt;/strong&gt;: Posts, Pages, Categor&iacute;as, Slides y Sections, todos traducibles ES/EN.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;API REST v1&lt;/strong&gt;: Endpoints p&uacute;blicos y autenticados, documentados con Scribe.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;SEO&lt;/strong&gt;: Meta tags, Open Graph, Twitter Cards, JSON-LD, sitemap XML y hreflang.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Docker&lt;/strong&gt;: Configuraci&oacute;n lista para desarrollo y producci&oacute;n.&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Tests&lt;/strong&gt;: Feature tests para autenticaci&oacute;n, API y rutas web.&lt;/li&gt;&lt;/ul&gt;&lt;h2&gt;Credenciales por defecto (seeders)&lt;/h2&gt;&lt;table&gt;&lt;thead&gt;&lt;tr&gt;&lt;th&gt;Email&lt;/th&gt;&lt;th&gt;Password&lt;/th&gt;&lt;th&gt;Rol&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;admin@example.com&lt;/td&gt;&lt;td&gt;password&lt;/td&gt;&lt;td&gt;superadmin&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;editor@example.com&lt;/td&gt;&lt;td&gt;password&lt;/td&gt;&lt;td&gt;admin&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;h2&gt;Inicio r&aacute;pido&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;cp .env.example .env\\ncomposer install &amp;amp;&amp;amp; npm install\\nphp artisan project:install\\nphp artisan serve\\nnpm run dev&lt;/code&gt;&lt;/pre&gt;&lt;p&gt;El comando &lt;code&gt;project:install&lt;/code&gt; genera la clave, crea el enlace de storage, ejecuta migraciones y seeders, todo con confirmaciones paso a paso.&lt;/p&gt;&lt;h2&gt;Estructura de directorios clave&lt;/h2&gt;&lt;pre&gt;&lt;code&gt;app/\\n├── Enums/          # Role, ContentStatus, EmailStatus\\n├── Filament/       # Admin/ y Panel/ (Filament resources)\\n├── Http/\\n│   ├── Controllers/Api/V1/   # Controladores REST\\n│   ├── Controllers/Web/      # Controladores frontend\\n│   └── Requests/             # FormRequests validados\\n├── Models/         # User, Post, Page, Category, Slide, Section, Setting, SentEmail\\n├── Services/       # EmailService, SeoService, SettingService, SitemapService\\n└── Traits/         # HasSlug, HasStatus, HasSeo, BelongsToUser&lt;/code&gt;&lt;/pre&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;Everything you need to know to understand this skeleton, what it includes and how to get the most out of it from day one.&quot;,
                &quot;es&quot;: &quot;Todo lo que necesitas saber para entender qu&eacute; es este skeleton, qu&eacute; incluye y c&oacute;mo sacarle partido desde el primer d&iacute;a.&quot;
            },
            &quot;image&quot;: &quot;posts/01KRDYR0S6VEGNRW0SF0E5Y8YV.png&quot;,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: true,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Introduction to Skeleton Laravel Project&quot;,
                &quot;es&quot;: &quot;Introducci&oacute;n al Skeleton Laravel Project&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Getting started guide: what it includes, structure, credentials and how to start the project.&quot;,
                &quot;es&quot;: &quot;Gu&iacute;a de inicio al skeleton: qu&eacute; incluye, estructura, credenciales y c&oacute;mo arrancar el proyecto.&quot;
            },
            &quot;seo_keywords&quot;: {
                &quot;en&quot;: null
            },
            &quot;published_at&quot;: &quot;2026-04-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-12T18:20:09.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;desarrollo&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Development&quot;,
                        &quot;es&quot;: &quot;Desarrollo&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 1,
                        &quot;category_id&quot;: 2
                    }
                },
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;documentacion&quot;,
                    &quot;name&quot;: {
                        &quot;en&quot;: &quot;Documentation&quot;,
                        &quot;es&quot;: &quot;Documentaci&oacute;n&quot;
                    },
                    &quot;pivot&quot;: {
                        &quot;post_id&quot;: 1,
                        &quot;category_id&quot;: 1
                    }
                }
            ]
        }
    ],
    &quot;first_page_url&quot;: &quot;http://localhost:8000/api/v1/posts?page=1&quot;,
    &quot;from&quot;: 1,
    &quot;last_page&quot;: 1,
    &quot;last_page_url&quot;: &quot;http://localhost:8000/api/v1/posts?page=1&quot;,
    &quot;links&quot;: [
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;&amp;laquo; Anterior&quot;,
            &quot;page&quot;: null,
            &quot;active&quot;: false
        },
        {
            &quot;url&quot;: &quot;http://localhost:8000/api/v1/posts?page=1&quot;,
            &quot;label&quot;: &quot;1&quot;,
            &quot;page&quot;: 1,
            &quot;active&quot;: true
        },
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;Siguiente &amp;raquo;&quot;,
            &quot;page&quot;: null,
            &quot;active&quot;: false
        }
    ],
    &quot;next_page_url&quot;: null,
    &quot;path&quot;: &quot;http://localhost:8000/api/v1/posts&quot;,
    &quot;per_page&quot;: 12,
    &quot;prev_page_url&quot;: null,
    &quot;to&quot;: 10,
    &quot;total&quot;: 10
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-posts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-posts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-posts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-posts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-posts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-posts" data-method="GET"
      data-path="api/v1/posts"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-posts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-posts"
                    onclick="tryItOut('GETapi-v1-posts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-posts"
                    onclick="cancelTryOut('GETapi-v1-posts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-posts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/posts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-posts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-posts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="posts-GETapi-v1-posts--slug-">Devuelve el detalle de un post específico identificado por su slug.</h2>

<p>
</p>

<p>Devuelve 404 si el post no existe, no está publicado o no está activo.</p>

<span id="example-requests-GETapi-v1-posts--slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/posts/2" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/posts/2"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-posts--slug-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 52
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
x-xss-protection: 1; mode=block
referrer-policy: strict-origin-when-cross-origin
permissions-policy: camera=(), microphone=(), geolocation=()
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Post].&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-posts--slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-posts--slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-posts--slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-posts--slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-posts--slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-posts--slug-" data-method="GET"
      data-path="api/v1/posts/{slug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-posts--slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-posts--slug-"
                    onclick="tryItOut('GETapi-v1-posts--slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-posts--slug-"
                    onclick="cancelTryOut('GETapi-v1-posts--slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-posts--slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/posts/{slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-posts--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-posts--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="slug"                data-endpoint="GETapi-v1-posts--slug-"
               value="2"
               data-component="url">
    <br>
<p>The slug of the post. Example: <code>2</code></p>
            </div>
                    </form>

                <h1 id="paginas">Páginas</h1>

    

                                <h2 id="paginas-GETapi-v1-pages">Devuelve un listado paginado de páginas publicadas y activas.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-pages">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/pages" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/pages"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-pages">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 51
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
x-xss-protection: 1; mode=block
referrer-policy: strict-origin-when-cross-origin
permissions-policy: camera=(), microphone=(), geolocation=()
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;slug&quot;: &quot;sobre-nosotros&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;About Us&quot;,
                &quot;es&quot;: &quot;Sobre Nosotros&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;We are a passionate team.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;Somos un equipo apasionado.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;Meet our team.&quot;,
                &quot;es&quot;: &quot;Conoce nuestro equipo.&quot;
            },
            &quot;image&quot;: &quot;pages/01KRDYQ637RZ8E1XWPBZPV0MNT.png&quot;,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: true,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: null
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: null
            },
            &quot;seo_keywords&quot;: {
                &quot;en&quot;: null
            },
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-12T11:21:25.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        },
        {
            &quot;id&quot;: 2,
            &quot;slug&quot;: &quot;servicios&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Services&quot;,
                &quot;es&quot;: &quot;Servicios&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;Our services.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;Nuestros servicios.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: null,
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: true,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: null,
            &quot;seo_description&quot;: null,
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        },
        {
            &quot;id&quot;: 3,
            &quot;slug&quot;: &quot;equipo&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Team&quot;,
                &quot;es&quot;: &quot;Equipo&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;Our team.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;Nuestro equipo.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: null,
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: null,
            &quot;seo_description&quot;: null,
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        },
        {
            &quot;id&quot;: 4,
            &quot;slug&quot;: &quot;faq&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;FAQ&quot;,
                &quot;es&quot;: &quot;Preguntas Frecuentes&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;FAQ.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;Preguntas frecuentes.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: null,
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: null,
            &quot;seo_description&quot;: null,
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        },
        {
            &quot;id&quot;: 5,
            &quot;slug&quot;: &quot;portfolio&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Portfolio&quot;,
                &quot;es&quot;: &quot;Portfolio&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;Our work.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;Nuestros trabajos.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: null,
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: true,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: null,
            &quot;seo_description&quot;: null,
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        },
        {
            &quot;id&quot;: 6,
            &quot;slug&quot;: &quot;clientes&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Clients&quot;,
                &quot;es&quot;: &quot;Clientes&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;Our clients.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;Nuestros clientes.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: null,
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: null,
            &quot;seo_description&quot;: null,
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        },
        {
            &quot;id&quot;: 7,
            &quot;slug&quot;: &quot;testimonios&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Testimonials&quot;,
                &quot;es&quot;: &quot;Testimonios&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;What they say.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;Lo que dicen de nosotros.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: null,
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: null,
            &quot;seo_description&quot;: null,
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        },
        {
            &quot;id&quot;: 10,
            &quot;slug&quot;: &quot;terminos&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Terms&quot;,
                &quot;es&quot;: &quot;T&eacute;rminos&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;Legal terms.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;T&eacute;rminos legales.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: null,
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: null,
            &quot;seo_description&quot;: null,
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        },
        {
            &quot;id&quot;: 11,
            &quot;slug&quot;: &quot;politica-privacidad&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Privacy Policy&quot;,
                &quot;es&quot;: &quot;Pol&iacute;tica de Privacidad&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;Here you will find the privacy policy of this site. Edit it from the administration panel.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;Aqu&iacute; se detalla la pol&iacute;tica de privacidad del sitio. Ed&iacute;tala desde el panel de administraci&oacute;n.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;Site privacy policy.&quot;,
                &quot;es&quot;: &quot;Pol&iacute;tica de privacidad del sitio.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Privacy Policy&quot;,
                &quot;es&quot;: &quot;Pol&iacute;tica de Privacidad&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Read our privacy policy.&quot;,
                &quot;es&quot;: &quot;Consulta nuestra pol&iacute;tica de privacidad.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        },
        {
            &quot;id&quot;: 12,
            &quot;slug&quot;: &quot;politica-cookies&quot;,
            &quot;title&quot;: {
                &quot;en&quot;: &quot;Cookies Policy&quot;,
                &quot;es&quot;: &quot;Pol&iacute;tica de Cookies&quot;
            },
            &quot;content&quot;: {
                &quot;en&quot;: &quot;&lt;p&gt;Here you will find the cookies policy of this site. Edit it from the administration panel.&lt;/p&gt;&quot;,
                &quot;es&quot;: &quot;&lt;p&gt;Aqu&iacute; se detalla la pol&iacute;tica de cookies del sitio. Ed&iacute;tala desde el panel de administraci&oacute;n.&lt;/p&gt;&quot;
            },
            &quot;excerpt&quot;: {
                &quot;en&quot;: &quot;Site cookies policy.&quot;,
                &quot;es&quot;: &quot;Pol&iacute;tica de cookies del sitio.&quot;
            },
            &quot;image&quot;: null,
            &quot;status&quot;: &quot;published&quot;,
            &quot;is_active&quot;: true,
            &quot;featured&quot;: false,
            &quot;user_id&quot;: 1,
            &quot;seo_title&quot;: {
                &quot;en&quot;: &quot;Cookies Policy&quot;,
                &quot;es&quot;: &quot;Pol&iacute;tica de Cookies&quot;
            },
            &quot;seo_description&quot;: {
                &quot;en&quot;: &quot;Read our cookies policy.&quot;,
                &quot;es&quot;: &quot;Consulta nuestra pol&iacute;tica de cookies.&quot;
            },
            &quot;seo_keywords&quot;: null,
            &quot;published_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;created_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-05-11T21:42:53.000000Z&quot;,
            &quot;deleted_at&quot;: null,
            &quot;categories&quot;: []
        }
    ],
    &quot;first_page_url&quot;: &quot;http://localhost:8000/api/v1/pages?page=1&quot;,
    &quot;from&quot;: 1,
    &quot;last_page&quot;: 1,
    &quot;last_page_url&quot;: &quot;http://localhost:8000/api/v1/pages?page=1&quot;,
    &quot;links&quot;: [
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;&amp;laquo; Anterior&quot;,
            &quot;page&quot;: null,
            &quot;active&quot;: false
        },
        {
            &quot;url&quot;: &quot;http://localhost:8000/api/v1/pages?page=1&quot;,
            &quot;label&quot;: &quot;1&quot;,
            &quot;page&quot;: 1,
            &quot;active&quot;: true
        },
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;Siguiente &amp;raquo;&quot;,
            &quot;page&quot;: null,
            &quot;active&quot;: false
        }
    ],
    &quot;next_page_url&quot;: null,
    &quot;path&quot;: &quot;http://localhost:8000/api/v1/pages&quot;,
    &quot;per_page&quot;: 12,
    &quot;prev_page_url&quot;: null,
    &quot;to&quot;: 10,
    &quot;total&quot;: 10
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-pages" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-pages"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-pages"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-pages" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-pages">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-pages" data-method="GET"
      data-path="api/v1/pages"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-pages', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-pages"
                    onclick="tryItOut('GETapi-v1-pages');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-pages"
                    onclick="cancelTryOut('GETapi-v1-pages');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-pages"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/pages</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-pages"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-pages"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="paginas-GETapi-v1-pages--slug-">Devuelve el detalle de una página específica identificada por su slug.</h2>

<p>
</p>

<p>Devuelve 404 si la página no existe, no está publicada o no está activa.</p>

<span id="example-requests-GETapi-v1-pages--slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/pages/2" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/pages/2"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-pages--slug-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 50
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
x-xss-protection: 1; mode=block
referrer-policy: strict-origin-when-cross-origin
permissions-policy: camera=(), microphone=(), geolocation=()
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Page].&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-pages--slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-pages--slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-pages--slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-pages--slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-pages--slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-pages--slug-" data-method="GET"
      data-path="api/v1/pages/{slug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-pages--slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-pages--slug-"
                    onclick="tryItOut('GETapi-v1-pages--slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-pages--slug-"
                    onclick="cancelTryOut('GETapi-v1-pages--slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-pages--slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/pages/{slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-pages--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-pages--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="slug"                data-endpoint="GETapi-v1-pages--slug-"
               value="2"
               data-component="url">
    <br>
<p>The slug of the page. Example: <code>2</code></p>
            </div>
                    </form>

                <h1 id="tokens-de-api">Tokens de API</h1>

    

                                <h2 id="tokens-de-api-GETapi-v1-user-tokens">Lista todos los tokens de API del usuario autenticado.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Los tokens se ordenan del más reciente al más antiguo.</p>

<span id="example-requests-GETapi-v1-user-tokens">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/user/tokens" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/user/tokens"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-user-tokens">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
x-xss-protection: 1; mode=block
referrer-policy: strict-origin-when-cross-origin
permissions-policy: camera=(), microphone=(), geolocation=()
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-user-tokens" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-user-tokens"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-user-tokens"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-user-tokens" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-user-tokens">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-user-tokens" data-method="GET"
      data-path="api/v1/user/tokens"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-user-tokens', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-user-tokens"
                    onclick="tryItOut('GETapi-v1-user-tokens');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-user-tokens"
                    onclick="cancelTryOut('GETapi-v1-user-tokens');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-user-tokens"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/user/tokens</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-user-tokens"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-user-tokens"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="tokens-de-api-POSTapi-v1-user-tokens">Crea un nuevo token de API para el usuario autenticado.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>El token en texto plano solo se devuelve en esta respuesta, no se puede recuperar después.</p>

<span id="example-requests-POSTapi-v1-user-tokens">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/user/tokens" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/user/tokens"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-user-tokens">
</span>
<span id="execution-results-POSTapi-v1-user-tokens" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-user-tokens"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-user-tokens"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-user-tokens" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-user-tokens">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-user-tokens" data-method="POST"
      data-path="api/v1/user/tokens"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-user-tokens', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-user-tokens"
                    onclick="tryItOut('POSTapi-v1-user-tokens');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-user-tokens"
                    onclick="cancelTryOut('POSTapi-v1-user-tokens');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-user-tokens"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/user/tokens</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-user-tokens"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-user-tokens"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-user-tokens"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
        </form>

                    <h2 id="tokens-de-api-DELETEapi-v1-user-tokens--tokenId-">Elimina un token de API específico del usuario autenticado.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Solo se puede eliminar un token propio, no de otros usuarios.</p>

<span id="example-requests-DELETEapi-v1-user-tokens--tokenId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost:8000/api/v1/user/tokens/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/user/tokens/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-user-tokens--tokenId-">
</span>
<span id="execution-results-DELETEapi-v1-user-tokens--tokenId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-user-tokens--tokenId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-user-tokens--tokenId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-user-tokens--tokenId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-user-tokens--tokenId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-user-tokens--tokenId-" data-method="DELETE"
      data-path="api/v1/user/tokens/{tokenId}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-user-tokens--tokenId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-user-tokens--tokenId-"
                    onclick="tryItOut('DELETEapi-v1-user-tokens--tokenId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-user-tokens--tokenId-"
                    onclick="cancelTryOut('DELETEapi-v1-user-tokens--tokenId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-user-tokens--tokenId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/user/tokens/{tokenId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-user-tokens--tokenId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v1-user-tokens--tokenId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>tokenId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="tokenId"                data-endpoint="DELETEapi-v1-user-tokens--tokenId-"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
